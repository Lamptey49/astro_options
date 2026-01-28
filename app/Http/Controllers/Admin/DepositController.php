<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;

class DepositController extends Controller
{
    /**
     * Display all deposits (with filters)
     */
     public function index()
    {
        $transactions = Transaction::with('user')
            ->where('type', 'deposit')
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.crypto.index', compact('transactions'));
    }

    public function approve($id)
    {
        $tx = Transaction::findOrFail($id);

        $tx->update(['status' => 'approved']);

        // credit user balance
        $tx->user->increment('balance', $tx->amount);

        return back()->with('success','Deposit approved');
    }

    /**
     * Reject a deposit
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255'
        ]);

        $deposit = Deposit::with('user')->findOrFail($id);

        if ($deposit->status !== 'pending') {
            return back()->withErrors('Deposit already processed.');
        }

        $deposit->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);

        // Optional email notification
        Mail::raw(
            "Your deposit has been rejected. Reason: {$request->reason}",
            function ($message) use ($deposit) {
                $message->to($deposit->user->email)
                        ->subject('Deposit Rejected');
            }
        );

        return back()->with('success', 'Deposit rejected.');
    }
}
