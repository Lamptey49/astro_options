<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use App\Mail\CryptoDepositStatusMail;


class CryptoTransactionController extends Controller
{
    public function index()
    {
        return view('admin.crypto.index', [
            'transactions' => Transaction::where('method', 'crypto')
                ->where('type', 'deposit')
                ->latest()
                ->get()
        ]);
    }

    public function approve(Transaction $transaction)
    {
       if ($transaction->status !== 'pending') return back();

        $transaction->user->increment('balance', $transaction->amount);

        $transaction->update(['status' => 'approved']);

        Mail::to($transaction->user->email)
            ->send(new CryptoDepositStatusMail($transaction));

        return back()->with('success', 'Crypto deposit approved and user notified');
    }

    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') return back();

        $transaction->update(['status' => 'rejected']);

        Mail::to($transaction->user->email)
            ->send(new CryptoDepositStatusMail($transaction));

        return back()->with('error', 'Crypto deposit rejected and user notified');
    }
}

