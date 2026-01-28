<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('admin.withdrawals.index', [
            'withdrawals' => Withdrawal::with('user')->latest()->get()
        ]);
    }

    public function approve(Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved']);
        return back();
    }

    public function reject(Withdrawal $withdrawal)
    {
        // refund balance
        $withdrawal->user->increment('balance', $withdrawal->amount);
        $withdrawal->update(['status' => 'rejected']);
        return back();
    }
}
