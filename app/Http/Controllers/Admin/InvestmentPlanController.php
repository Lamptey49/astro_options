<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPlan;
use Illuminate\Http\Request;

class InvestmentPlanController extends Controller
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
            'max_amount'=>'required|numeric',
            'duration_days'=>'required|integer',
            'roi_percent'=>'required|numeric',
            'features'=>'required',
            'is_active'=>'sometimes|boolean',
        ]);

        try {
            InvestmentPlan::create([
                'name'=>$request->name,
                'min_amount'=>$request->min_amount,
                'max_amount'=>$request->max_amount,
                'duration_days'=>$request->duration_days,
                'roi_percent'=>$request->roi_percent,
                'features'=>$request->features,
                'is_active'=>$request->has('is_active') ? $request->is_active : true,
            ]);

            return redirect()->route('admin.plans.index')
                ->with('success','Plan created successfully');
        } catch (\Exception $e) {
            \Log::error('Investment Plan Creation Error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error','Failed to create plan: ' . $e->getMessage());
        }
    }
}
