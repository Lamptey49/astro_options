<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Investment;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Models\Trade;
use App\Models\Deposit;

class DashboardController extends Controller
{ 

public function index()
{
    $totalTrades = Trade::count();
    
    $tradeTypes = Trade::select('side', DB::raw('COUNT(*) as total'))
        ->groupBy('side')
        ->get();

    $tradeStatus = Trade::select('status', DB::raw('COUNT(*) as total'))
        ->groupBy('status')
        ->get();

    $profitTrend = Trade::whereNotNull('take_profit')
        ->orderBy('created_at')
        ->pluck('take_profit')
        ->toArray();
    // Chart data: approved crypto deposits per day
        $cryptoTrend = Deposit::where('method', 'crypto')
            ->where('status', 'approved')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
            $byMethod = Withdrawal::select('method', DB::raw('SUM(amount) as total'))
            ->where('status','approved')
            ->groupBy('method')
            ->get();
        

        return view('admin.dashboard', [
            'users' => User::count(),

            'totalDeposits' => Deposit::where('status', 'approved')
                ->sum('amount'),

            'pendingCrypto' => Deposit::where('method', 'crypto')
                ->where('status', 'pending')
                ->count(),

            'investments' => Investment::sum('amount'),

            'totalWithdrawals' => Withdrawal::where('status','approved')->sum('amount'),

            'totalTrades' => $totalTrades,
            'tradeTypeLabels' => $tradeTypes->pluck('side'),
            'tradeTypeData' => $tradeTypes->pluck('total'),
            'statusLabels' => $tradeStatus->pluck('status'),
            'statusData' => $tradeStatus->pluck('total'),
            'profitTrend' => $profitTrend,

            'Datalabels' => $byMethod->pluck('method')->toArray(),
            'data' => $byMethod->pluck('total')->toArray(),

            // FIXED VARIABLES
            'labels' => $cryptoTrend->pluck('date'),
            'values' => $cryptoTrend->pluck('total'),
        ]);
    
}
}