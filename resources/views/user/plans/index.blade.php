@extends('user.layout')
@section('content')
<head>
    <title>  {{ settings('site_name') }} | Investment Plans</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
</head>
    <div class="p-6">
        <h1 class="text-3xl font-bold mb-6">Investment Plans</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($plans as $plan)
                <div class="bg-gray-800 p-6 rounded-lg shadow-md">
                    <h2 class="text-xl font-semibold mb-4">{{ $plan->name }}</h2>
                    <p class="text-gray-400 mb-4">Price: ${{ number_format($plan->price, 2) }}</p>
                    <p class="text-gray-400 mb-4">Duration: {{ $plan->duration }} days</p>
                    <ul class="list-disc list-inside mb-6">
                        @foreach(explode(',', $plan->features) as $feature)
                            <li class="text-gray-400">✔ {{ trim($feature) }}</li>
                        @endforeach
                    </ul>
                    <form action="{{ route('user.plans.create', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Subscribe</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>