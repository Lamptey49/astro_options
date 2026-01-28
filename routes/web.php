<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\WalletController; 
use App\Http\Controllers\TradeController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\Services\BinanceService;
use App\Models\Watchlist;
use App\Models\TradingPair;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
   
    // API endpoint to get user balance
    Route::get('/api/user', function () {
        return response()->json(auth()->user()->only(['balance', 'demo_balance']));
    });

    Route::get('/investments', [InvestmentController::class,'index']);
    Route::post('/invest', [InvestmentController::class,'store']);
    Route::post('/investment/{investment}/cancel',[InvestmentController::class,'cancel'])
    ->middleware('auth');

   
   Route::get('/deposit', [DepositController::class,'create'])->name('deposit.create');

    // Crypto
    Route::post('/deposit/crypto', [DepositController::class,'storeCrypto'])
        ->name('deposit.crypto');

    // Flutterwave
    Route::post('/deposit/card', [DepositController::class,'payWithFlutterwave'])
        ->name('deposit.card');

    Route::get('/deposit/flutterwave/callback',
        [DepositController::class,'flutterwaveCallback']
    )->name('deposit.flutterwave.callback');
    
    Route::get('/deposit/crypto', function () {
    return view('wallet.crypto');
    })->middleware('auth')->name('crypto.deposit');

    Route::get('/deposit/card', function () {
        return view('wallet.card');
    })->middleware('auth')->name('card.deposit');

    Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals');
    Route::post('/withdrawals', [WithdrawalController::class, 'store']);
    Route::post('/trade/place', [TradeController::class,'placeTrade'])
    ->middleware('auth')
    ->name('trade.place');
     Route::get('/trade', [TradeController::class, 'index'])->name('trade');
    Route::post('/trade', [TradeController::class, 'store'])->name('trade.store');
    Route::get('/chart-data', [TradeController::class, 'chartData']);

    Route::post('/demo/reset', function () {
    auth()->user()->update(['demo_balance' => 10000]);
    return back()->with('success','Demo balance reset');
    })->middleware('auth');

    Route::post('/trade/mode', function (Request $request) {
    session(['trade_mode' => $request->mode]);
    return response()->json(['ok']);
    })->middleware('auth');
    Route::get('/market/candles/{symbol}/{interval?}', 
    [MarketController::class, 'candles']);
   Route::get('/trade/open', [TradeController::class, 'openTrades'])
        ->name('trade.open');
    Route::get('/market/candles', [MarketController::class, 'candles']);

    Route::get('/trade/markers', [TradeController::class, 'markers'])->middleware('auth');

    Route::get('/market/price/{symbol}', function ($symbol) {

    $pair = TradingPair::where('symbol',$symbol)->firstOrFail();

    $price = BinanceService::getPrice($pair->binance_symbol);

        return response()->json([
            'symbol' => $symbol,
            'price' => $price
        ]);
    });
    Route::get('/market/price/{pair}', [MarketController::class, 'price']);
    Route::post('/trade/{trade}/close', [TradeController::class, 'close'])
    ->name('trade.close');
    Route::get('/trade/{trade}/chart', [TradeController::class, 'chart']);

    Route::post('/watchlist/add/{pair}', function ($pairId) {
        Watchlist::firstOrCreate([
            'user_id' => auth()->id(),
            'trading_pair_id' => $pairId
        ]);

        return back()->with('success','Added to watchlist');
        })->middleware('auth');

    Route::delete('/watchlist/remove/{pair}', function ($pairId) {
        Watchlist::where('user_id',auth()->id())
            ->where('trading_pair_id',$pairId)
            ->delete();

        return back()->with('success','Removed from watchlist');
    })->middleware('auth');
    Route::get('/lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'fr', 'es'])) {
            session(['locale' => $locale]);
        }
        return back();
    });

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
