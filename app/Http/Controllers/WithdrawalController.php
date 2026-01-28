<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Mail\WithdrawalStatusMail;
use Illuminate\Support\Facades\Mail;

class WithdrawalController extends Controller
{
    public function index()
    {
        return view('user.withdrawals.index', [
            'withdrawals' => Withdrawal::where('user_id', auth()->id())->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = auth()->user();

        if (!$user->live_trading_enabled) {
            return back()->withErrors('Deposit required before withdrawal');
        }

        if ($user->balance < $request->amount) {
            return back()->withErrors('Insufficient balance');
        }

        DB::transaction(function () use ($user, $request) {

            // Deduct balance immediately
            $user->decrement('balance', $request->amount);

            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'status' => 'pending'
            ]);
        });

        return back()->with('success','Withdrawal request submitted');
    }

    public function approve(Withdrawal $withdrawal)
    {
        $withdrawal->update(['status' => 'approved']);

        Mail::to($withdrawal->user->email)
            ->send(new WithdrawalStatusMail($withdrawal));

        return back()->with('success','Withdrawal approved');
    }
    public function reject(Withdrawal $withdrawal)
    {
        $withdrawal->user->increment('balance', $withdrawal->amount);
        $withdrawal->update(['status' => 'rejected']);

        Mail::to($withdrawal->user->email)
            ->send(new WithdrawalStatusMail($withdrawal));

        return back()->with('success','Withdrawal rejected');
    }

}
