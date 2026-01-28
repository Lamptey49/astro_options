<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class CryptoAnalyticsController extends Controller
{
    public function index()
    {
        return view('admin.crypto.analytics', [
            'totalDeposits' => Transaction::where('method', 'crypto')
                ->where('status', 'approved')
                ->sum('amount'),

            'totalCount' => Transaction::where('method', 'crypto')
                ->where('status', 'approved')
                ->count(),

            'byCrypto' => Transaction::where('method', 'crypto')
                ->where('status', 'approved')
                ->select('crypto_type', DB::raw('SUM(amount) as total'))
                ->groupBy('crypto_type')
                ->get(),
        ]);
    }
}

