<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvestmentPlan;
use App\Models\UserInvestment;

class InvestmentController extends Controller
{
    public function index()
    {
        $plans = InvestmentPlan::where('is_active',1)->get();
        $investments = UserInvestment::all();

        return view('user.investments.index', compact('plans','investments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plan_id'=>'required|exists:investment_plans,id',
            'amount'=>'required|numeric'
        ]);

        $plan = InvestmentPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        if($request->amount < $plan->min_amount || $request->amount > $plan->max_amount){
            return back()->with('error','Invalid investment amount');
        }

        if($user->balance < $request->amount){
            return back()->with('error','Insufficient balance');
        }

        $expected = $request->amount + ($request->amount * $plan->roi_percentage / 100);

        UserInvestment::create([
            'user_id'=>$user->id,
            'investment_plan_id'=>$plan->id,
            'amount'=>$request->amount,
            'expected_return'=>$expected,
            'start_date'=>now(),
            'end_date'=>now()->addDays($plan->duration_days),
        ]);

        $user->decrement('balance', $request->amount);

        return back()->with('success','Investment successful');
    }
    public function cancel(UserInvestment $investment)
    {
        if ($investment->user_id !== auth()->id()) {
            abort(403);
        }

        if ($investment->status !== 'active') {
            return back()->with('error','Investment not active');
        }

        if ($investment->progress >= 30) {
            return back()->with('error','Cancellation window closed');
        }

        $refund = $investment->amount * 0.9; // 10% penalty

        $investment->user->increment('balance', $refund);

        $investment->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success','Investment cancelled. Refund issued.');
    }

}
