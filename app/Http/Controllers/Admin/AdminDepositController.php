<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;

class AdminDepositController extends Controller
{
    public function index()
    {
        $deposits = Deposit::latest()->get();
        return view('admin.crypto.index',compact('deposits'));
    }

    public function approve(Deposit $deposit)
    {
        if($deposit->status !== 'pending') return back();

        $deposit->update(['status'=>'approved']);
        $deposit->user->increment('balance',$deposit->amount);
        $deposit->user->update([
        'live_trading_enabled' => true
        ]);

        return back()->with('success','Deposit approved');
    }

    public function reject(Deposit $deposit)
    {
        $deposit->update(['status'=>'rejected']);
        return back()->with('error','Deposit rejected');
    }
}
