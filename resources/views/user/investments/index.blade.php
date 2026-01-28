@extends('user.layout')
@section('content')
<head>
    <title>  {{ settings('site_name') }} | Investments</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
</head>
<div class="max-w-4xl mx-auto p-6 space-y-8">
    <h1 class="text-2xl font-bold">💼 Investments</h1>
    <p class="text-gray-400 text-sm">
        View and manage your investment plans.
    </p>

    <h3>Select Investment Plan</h3>
    <div class="grid md:grid-cols-3 gap-8">
        @foreach($plans as $plan)
        <div class="relative bg-gradient-to-br from-indigo-600/20 to-purple-600/10 p-6 rounded-2xl border border-white/10 hover:scale-105 transition">

            <h3 class="text-xl font-bold mb-2">{{ $plan->name }}</h3>

            <ul class="text-sm text-gray-300 space-y-2 mb-6">
                <li>ROI: <strong>{{ $plan->roi_percent }}%</strong></li>
                <li>Duration: {{ $plan->duration_days }} days</li>
                <li>Min: ${{ $plan->min_amount }}</li>
                <li>Max: ${{ $plan->max_amount }}</li>
            </ul>

            <form method="POST" action="/invest">
                @csrf
                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                <input type="hidden" name="amount" value="0"
                    class="w-full mb-4 bg-black/50 border border-white/10 rounded px-4 py-2">

                <button class="w-full py-2 rounded bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
                   Contact Support to Buy/Upgrade Plan
                </button>
            </form>
        </div>
        @endforeach
    </div>
    <h4>My Active Investments</h4>

    @foreach($investments as $investment)
    <div class="investment-card">

        <p>Plan: {{ $investment->plan->name }}</p>
        <p>Amount: ${{ number_format($investment->amount,2) }}</p>
        <p>Expected Return: ${{ number_format($investment->expected_return,2) }}</p>
        <p>Status: {{ ucfirst($investment->status) }}</p>

        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $investment->progress }}%">
                {{ $investment->progress }}%
            </div>
        </div>
        @if($investment->status === 'active' && $investment->progress < 30)
        <form method="POST" action="/investment/{{ $investment->id }}/cancel">
        @csrf
        <button class="cancel-btn">Cancel Investment</button>
        </form>
        @endif
    </div>
    @endforeach
      

@endsection