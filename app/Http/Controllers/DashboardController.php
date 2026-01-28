<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use App\Models\Transaction;
use App\Http\Controllers\User\TradeController;
use App\Models\Trade;
use App\Models\User;
use App\Models\Watchlist;
use App\Models\Wallet;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
      public function index()
    {

       $user = auth()->user();

        if ($user->balance <= 0) {
            $user->mode = 'demo';
            $user->save();
        }
        Wallet::where('user_id', auth()->id())
        ->where('mode', session('trade_mode'))
        ->first();

        $plans = InvestmentPlan::where('is_active', true)->get();
        // Recent trades
        $trades = Trade::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        // Monthly deposits
        $totalDeposits = Transaction::where('type','deposit')
            ->where('status','approved')
            ->selectRaw('MONTH(created_at) month, SUM(amount) total')
            ->groupBy('month')
            ->pluck('total','month')
            ->count();
        $watchlist = Watchlist::where('user_id',auth()->id())
        ->with('pair')
        ->get();

        // Monthly withdrawals
        $withdrawals = Transaction::where('type','withdrawal')
        ->where('status','approved')
        ->selectRaw('MONTH(created_at) month, SUM(amount) total')
        ->groupBy('month')
        ->pluck('total','month')
        ->count();
        $plans = Investment::selectRaw('investment_plan_id, COUNT(*) total')
        ->groupBy('investment_plan_id')
        ->pluck('total','investment_plan_id');
        $pendingCrypto = Transaction::where('method', 'crypto')
                ->where('status', 'pending')
                ->count();
        // Metric cards
        $userCount       = User::count();
        $investmentCount = Investment::count();
        $totalFunds      = Investment::sum('amount');
        // Chart data (investment / trading history)
        $chartLabels = Trade::where('user_id', $user->id)
            ->orderBy('created_at')
            ->pluck('created_at')
            ->map(fn($date) => $date->format('M d'))
            ->toArray();

        $chartData = Trade::where('user_id', $user->id)
            ->orderBy('created_at')
            ->pluck('take_profit')
            ->toArray();

        return view('dashboard.index', compact(
            'user',
            'trades',
            'plans',
            'watchlist',
            'investmentCount',
            'totalFunds',
            'chartLabels',
            'chartData'
        ));
    }
}
