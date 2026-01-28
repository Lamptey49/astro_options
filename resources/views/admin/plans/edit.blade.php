@extends('admin.layout')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Edit Plan</h1>

        <form method="POST" action="{{ route('admin.plans.update', $plan->id) }}">
            @csrf
            @method('PUT')
        <div>
             <label for="name" class="block text-sm font-medium mb-1">Plan Name</label>
            <input name="name" value="{{ $plan->name }}" class=" p-2 input border border-gray-300 rounded" placeholder="Plan Name" required>
        </div>
        <div>
             <label for="min_amount" class="block text-sm font-medium mb-1">Minimum (USD)</label>
        <input name="min_amount" value="{{ $plan->min_amount }}" class="p-2 input border border-gray-300 rounded" placeholder="Min Amount" required>
        </div>
        <div>
             <label for="max_amount" class="block text-sm font-medium mb-1">Maximum (USD)</label>
        <input name="max_amount" value="{{ $plan->max_amount }}" class=" p-2 input border border-gray-300 rounded" placeholder="Max Amount" required>
        </div>
        <div>
             <label for="duration_days" class="block text-sm font-medium mb-1">Duration (Days)</label>  
        <input name="duration_days" value="{{ $plan->duration_days }}" class=" p-2 input border border-gray-300 rounded" placeholder="Duration (Days)" required>
        </div>
        <div>
        <label for="roi_percent" class="block text-sm font-medium mb-1">ROI (%)</label>
        <input name="roi_percent" value="{{ $plan->roi_percent }}" class=" p-2 input border border-gray-300 rounded" placeholder="ROI %" required>
        </div>      
        <div>
        <label for="features" class="block text-sm font-medium mb-1">Features (Comma Separated)</label>
        <input type="text" name="features" value="{{ $plan->features }}" class=" p-2 input border border-gray-300 rounded" placeholder="Features" required>
        </div>
            <button  class="bg-blue-600 text-white px-4 p-4 py-2 rounded hover:bg-blue-700 mt-4">Update Plan</button>
        </form>
    </div>
@endsection