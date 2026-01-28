@extends('admin.layout')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Investment Plans</h1>

        <a href="{{ route('admin.plans.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">Create New Plan</a>

        <table class="w-full table-auto border-collapse border border-gray-700">
            <thead>
                <tr class="bg-gray-800">
                    <th class="border border-gray-600 px-4 py-2">Name</th>
                    <th class="border border-gray-600 px-4 py-2">Price (USD)</th>
                    <th class="border border-gray-600 px-4 py-2">Duration (Days)</th>
                    <th class="border border-gray-600 px-4 py-2">Features</th>
                    <th class="border border-gray-600 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                    <tr class="bg-gray-700">
                        <td class="border border-gray-600 px-4 py-2">{{ $plan->name }}</td>
                        <td class="border border-gray-600 px-4 py-2">${{ number_format($plan->min_amount, 2) }}</td>
                        <td class="border border-gray-600 px-4 py-2">{{ $plan->duration_days }}</td>
                        <td class="border border-gray-600 px-4 py-2">
                            <ul class="list-disc list-inside">
                                @foreach(explode(',', $plan->features) as $feature)
                                    <li>{{ trim($feature) }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border border-gray-600 px-4 py-2">
                            <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <form action="{{ route('admin.plans.destroy', $plan->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
        
    </div>
@endsection


