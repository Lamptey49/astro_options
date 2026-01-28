@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
<h1 class="text-2xl mb-6">📊 Investment History</h1>

<table class="w-full">
<thead>
<tr class="border-b">
    <th>Plan</th>
    <th>Amount</th>
    <th>Profit</th>
    <th>Status</th>
    <th>End Date</th>
</tr>
</thead>
<tbody>
@foreach($investments as $inv)
<tr class="border-b">
    <td>{{ $inv->plan->name }}</td>
    <td>${{ number_format($inv->amount,2) }}</td>
    <td class="text-green-400">${{ number_format($inv->profit,2) }}</td>
    <td>{{ ucfirst($inv->status) }}</td>
    <td>{{ $inv->end_date->format('d M Y') }}</td>
</tr>
@endforeach
</tbody>
</table>

<div class="mt-6">{{ $investments->links() }}</div>
</div>
@endsection
