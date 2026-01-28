<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;

class AdminInvestmentPlanController extends Controller
{
    public function index()
    {
        $plans = InvestmentPlan::latest()->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'min_amount'=>'required|numeric',
            'max_amount'=>'required|numeric|gt:min_amount',
            'duration_days'=>'required|integer',
            'roi_percent'=>'required|numeric',
            'features'=>'nullable|string',
        ]);

        InvestmentPlan::create($request->all());

        return redirect()->route('admin.plans.index')->with('success','Plan created');
    }

    public function edit(InvestmentPlan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, InvestmentPlan $plan)
    {
        $plan->update($request->all());
        return back()->with('success','Plan updated');
    }
     public function destroy(InvestmentPlan $plan){
        $plan->delete();
        return back()->with('success','Plan deleted');
     }
}

