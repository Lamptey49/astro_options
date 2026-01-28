<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Investment;
use App\Models\InvestmentPlan;
use App\Models\Transaction; 

class WalletController extends Controller
{
    public function index(){
        return view('wallet.index',[
            'withdrawals'=>Transaction::where('user_id',auth()->id())
            ->where('type','withdrawal')
            ->latest()
            ->get()
        ]);
    }
    
    public function deposit()
    {
        return view('wallet.deposit');
    }

    public function storeDeposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'crypto' => 'required|string',
            'tx_hash' => 'required|string'
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'type'    => 'deposit',
            'method'  => 'crypto',
            'crypto'  => $request->crypto,
            'hash' => $request->tx_hash,
            'amount'  => $request->amount,
            'status'  => 'pending'
        ]);
        return back()->with('success', 'Deposit submitted and awaiting approval.');
    }

    public function withdraw(Request $request)
    {
        Transaction::create([
            'user_id'=>auth()->id(),
            'type'=>'withdrawal',
            'amount'=>$request->amount
        ]);
        return back()->with('success','Withdrawal request sent');
    }
}
