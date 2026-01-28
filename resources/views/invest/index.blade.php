@extends('user.layout')

@section('content')
<h2 class="text-3xl font-semibold mb-8">Investment Plans</h2>

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

    <form method="POST" action="{{ route('investments.store') }}">
        @csrf
        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
        <input type="number" name="amount" placeholder="Amount"
            class="w-full mb-4 bg-black/50 border border-white/10 rounded px-4 py-2">

        <button class="w-full py-2 rounded bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
            Invest Now
        </button>
    </form>
</div>
@endforeach
</div>
@endsection
