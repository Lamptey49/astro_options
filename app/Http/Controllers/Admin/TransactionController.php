<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Investment;
use App\Models\Transaction;

class TransactionController extends Controller{

 
   
     public function index(Request $request)
    {
        $query = Transaction::with('user')->latest();

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return view('admin.transactions.index', [
            'transactions' => $query->paginate(15),
        ]);
    }

   public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') return back();

        if ($transaction->type === 'deposit') {
            $transaction->user->increment('balance', $transaction->amount);
        }

        if ($transaction->type === 'withdrawal') {
            $transaction->user->decrement('balance', $transaction->amount);
        }

        $transaction->update(['status' => 'approved']);

        return back()->with('success', 'Transaction approved');
    }


    public function reject(Transaction $transaction)
    {
        if (!$transaction->isPending()) {
            return back()->withErrors('Transaction already processed.');
        }

        DB::transaction(function () use ($transaction) {

            if ($transaction->type === 'withdrawal') {
                // refund balance
                $transaction->user->increment('balance', $transaction->amount);
            }

            $transaction->update(['status' => 'rejected']);
        });

        return back()->with('success', 'Transaction rejected.');
    }
}
