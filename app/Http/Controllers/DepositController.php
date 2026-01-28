<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deposit;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DepositController extends Controller
{
    public function create()
    {
        return view('wallet.deposit');
    }

    /* =========================
       CRYPTO DEPOSIT
    ========================== */
    public function storeCrypto(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10',
            'currency' => 'required',
            'tx_hash' => 'required',
            'proof' => 'required|image|max:2048'
        ]);

        $path = $request->file('proof')->store('crypto-proofs','public');

        Deposit::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => 'crypto',
            'currency' => $request->currency,
            'tx_hash' => $request->tx_hash,
            'proof' => $path,
            'status' => 'pending'
        ]);

        return back()->with('success','Crypto deposit submitted. Awaiting approval.');
    }

    /* =========================
       FLUTTERWAVE CARD PAYMENT
    ========================== */
    public function payWithFlutterwave(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10'
        ]);

        $tx_ref = 'DEP-'.uniqid();

        $deposit = Deposit::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'method' => 'card',
            'status' => 'pending'
        ]);

        $response = Http::withToken(config('services.flutterwave.secret_key'))
            ->post('https://api.flutterwave.com/v3/payments',[
                'tx_ref' => $tx_ref,
                'amount' => $request->amount,
                'currency' => 'USD',
                'redirect_url' => route('deposit.flutterwave.callback'),
                'customer' => [
                    'email' => auth()->user()->email,
                ],
                'meta' => [
                    'deposit_id' => $deposit->id
                ]
            ]);

        return redirect($response['data']['link']);
    }

    public function flutterwaveCallback(Request $request)
    {
        if ($request->status !== 'successful') {
            return redirect('/deposit')->with('error','Payment failed');
        }

        $depositId = $request->meta['deposit_id'];

        $deposit = Deposit::findOrFail($depositId);

        $deposit->update(['status'=>'approved']);

        $deposit->user->increment('balance',$deposit->amount);

        return redirect('/dashboard')->with('success','Deposit successful');
    }
}
