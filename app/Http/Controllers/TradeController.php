<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Trade;
use App\Models\TradingPair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\MarketDataService;
use App\Models\Wallet;

class TradeController extends Controller
{
    public function index()
    {
        $pairs = TradingPair::where('is_active', true)->get();

        if ($pairs->isEmpty()) {
            abort(500, 'Trading pairs not configured');
        }

        $pairId = request('pair');
        $auth = auth()->user();
        $selectedPair = $pairId
            ? TradingPair::find($pairId)
            : $pairs->first();

        if (!$selectedPair) {
            abort(500, 'Invalid trading pair selected');
        }

        // $candles = $this->generateCandles($selectedPair->price);

        $lastTrade = Trade::where('user_id', auth()->id())
        ->latest()
        ->first();
        $mode = session('trade_mode', 'demo'); // default demo
        $hasLiveFunds = auth()->user()->balance > 0;

        return view('user.trade.index', [
            'pairs' => $pairs,
            'defaultPair' => 'BTCUSDT',
            'selectedPair' => $selectedPair,
            // 'candles' => $candles,
            'lastTrade' => $lastTrade,
            'trades' => Trade::where('user_id', auth()->id())->latest()->get(),
            'mode' =>$mode,
            'hasLiveFunds' => $hasLiveFunds
        ]);
    }

public function placeTrade(Request $request)
{
    $request->validate([
        'pair'      => 'required|string',
        'side'      => 'required|in:buy,sell',
        'amount'    => 'required|numeric|min:1',
        'price'     => 'required|numeric',
        'mode'      => 'required|in:demo,live',
        'stop_loss' => 'nullable|numeric',
        'take_profit' => 'nullable|numeric',
    ]);

    $user = auth()->user();

    // 🔥 FIX 1: Correct balance source
    $balanceField = $request->mode === 'live'
        ? 'balance'
        : 'demo_balance';

    if ($user->$balanceField < $request->amount) {
        return response()->json([
            'message' => 'Insufficient balance'
        ], 422);
    }

    DB::transaction(function () use ($user, $request, $balanceField) {

        // 🔥 FIX 2: Deduct FIRST
        $user->decrement($balanceField, $request->amount);

        // 🔥 FIX 3: Create trade AFTER deduction
        Trade::create([
            'user_id'      => $user->id,
            'pair'         => $request->pair,
            'side'         => $request->side,
            'amount'       => $request->amount,
            'entry_price' => $request->price,
            'mode'         => $request->mode,
            'stop_loss'    => $request->stop_loss,
            'take_profit' => $request->take_profit,
            'status'       => 'open',
            'opened_at'    => now(),
        ]);
    });

    return response()->json([
        'success' => true,
        'message' => 'Trade placed successfully'
    ]);
}

public function chartData(Request $request)
{
    $pair = $request->pair;         // BTCUSDT
    $tf   = mapInterval($request->tf);

    $candles = app(BinanceService::class)
        ->candles($pair, $tf, 200);

    return response()->json(
        collect($candles)->map(fn ($c) => [
            'time'  => $c['open_time'] / 1000,
            'open'  => (float) $c['open'],
            'high'  => (float) $c['high'],
            'low'   => (float) $c['low'],
            'close' => (float) $c['close'],
        ])
    );
}


public function chart(Trade $trade)
{
    return view('trade.chart', compact('trade'));
}

public function markers(Request $request)
{
    return Trade::where('user_id', auth()->id())
        ->where('status', 'open')
        ->where('pair', $request->pair)
        ->get()
        ->map(fn ($t) => [
            'time' => strtotime($t->created_at),
            'position' => $t->side === 'buy' ? 'belowBar' : 'aboveBar',
            'color' => $t->side === 'buy' ? '#22c55e' : '#ef4444',
            'shape' => $t->side === 'buy' ? 'arrowUp' : 'arrowDown',
            'text' => strtoupper($t->side)
        ]);
}

public function switchMode(Request $request)
{
    session([
        'trade_mode' => $request->mode,
        'trade_pair' => $request->pair
    ]);

    return response()->json(['ok'=>true]);
}

public function store(Request $request)
{
    $request->validate([
        'pair' => 'required',
        'side' => 'required|in:buy,sell',
        'amount' => 'required|numeric|min:1',
        'mode' => 'required|in:demo,live',
        'stop_loss' => 'nullable|numeric',
        'take_profit' => 'nullable|numeric'
    ]);

    $user = auth()->user();
    
    // Determine which balance to use
    $balanceField = $request->mode === 'live' ? 'balance' : 'demo_balance';
    $currentBalance = $user->$balanceField;

    // Check if user has sufficient balance
    if ($currentBalance < $request->amount) {
        return response()->json([
            'error' => 'Insufficient ' . ($request->mode === 'live' ? 'balance' : 'demo balance')
        ], 422);
    }

    try {
        // Fetch the current market price for the trading pair
        $pair = TradingPair::where('binance_symbol', $request->pair)->first();
        if (!$pair) {
            return response()->json([
                'error' => 'Trading pair not found'
            ], 404);
        }

        $entryPrice = MarketDataService::getPrice($pair->binance_symbol);
        if (!$entryPrice || $entryPrice <= 0) {
            return response()->json([
                'error' => 'Unable to fetch current market price'
            ], 500);
        }

        // Deduct the amount from balance
        $user->decrement($balanceField, $request->amount);

        // Create the trade with actual market price
        Trade::create([
            'user_id' => $user->id,
            'pair' => $request->pair,
            'side' => $request->side,
            'entry_price' => (float) $entryPrice,
            'amount' => $request->amount,
            'stop_loss' => $request->stop_loss,
            'take_profit' => $request->take_profit,
            'mode' => $request->mode,
            'status' => 'open'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trade placed successfully',
            'balance' => $user->refresh()->$balanceField
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to place trade: ' . $e->getMessage()
        ], 500);
    }
}



private function generateCandles(float $basePrice)
{
    $candles = MarketDataService::getCandles('BTCUSDT', '5m');


    return $candles;
}
public function balance(Request $request)
{
    $balance = Balance::firstOrCreate([
        'user_id' => auth()->id(),
        'pair' => $request->pair,
        'mode' => session('trade_mode','demo')
    ], [
        'amount' => session('trade_mode') === 'demo' ? 10000 : 0
    ]);

    return response()->json($balance);
}


public function openTrades(Request $request)
{
    $mode = $request->query('mode', 'demo');

    $trades = Trade::where('user_id', auth()->id())
        ->where('status', 'open')
        ->where('mode', $mode)
        ->latest()
        ->get()
        ->map(function($trade) {
            return [
                'id' => $trade->id,
                'pair' => $trade->pair,
                'side' => $trade->side,
                'amount' => $trade->amount,
                'entry_price' => $trade->entry_price,
                'stop_loss' => $trade->stop_loss,
                'take_profit' => $trade->take_profit,
                'pnl' => $trade->pnl ?? 0,
                'status' => $trade->status,
                'mode' => $trade->mode,
                'created_at' => $trade->created_at
            ];
        });

    return response()->json($trades);
}
public function close(Trade $trade)
{
    abort_if($trade->user_id !== auth()->id(), 403);

    if ($trade->status !== 'open') {
        return back();
    }

    $price = MarketDataService::getPrice($trade->pair);

    $pnl = $trade->side === 'buy'
        ? ($price - $trade->entry_price) * $trade->amount
        : ($trade->entry_price - $price) * $trade->amount;

    $trade->update([
        'exit_price' => $price,
        'pnl' => $pnl,
        'status' => 'closed',
        'closed_at' => now()
    ]);

    // CREDIT / DEBIT BALANCE
    $wallet = Wallet::where('user_id', $trade->user_id)
        ->where('mode', $trade->mode)
        ->first();

    $wallet->increment('balance', $pnl);

    return response()->json(['success' => true]);
}


}
