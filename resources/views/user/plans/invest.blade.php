@extends('user.layout')

@section('content')
    <div class="p-6 max-w-md mx-auto bg-gray-800 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold mb-6 text-center">Invest in {{ $plan->name }}</h1>

        <form action="{{ route('user.plans.subscribe', $plan->id) }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <div>
                <label for="amount" class="block text-sm font-medium mb-1">Investment Amount (USD)</label>
                <input type="number" name="amount" id="amount" step="0.01" min="{{ $plan->price }}" class="w-full p-2 border border-gray-300 rounded" required>
                <p class="text-xs text-gray-400 mt-1">Minimum amount: ${{ number_format($plan->price, 2) }}</p>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Invest Now</button>
            </div>
        </form>
    </div>