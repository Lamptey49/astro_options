@extends('admin.layout')

@section('content')
<div class="p-6">

<h1 class="text-2xl font-bold mb-6">🪙 Crypto Deposit Confirmations</h1>

@if(session('success'))
    <p class="text-green-400 mb-4">{{ session('success') }}</p>
@endif

<table class="w-full bg-white/5 rounded overflow-hidden">
    <form method="GET">
        <select class="status input" name="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <button class="btn btn-primary" type="submit">Filter</button>
    </form>

    <thead class="bg-white/10">
    <tr>
        <th class="p-4 text-left">User</th>
        <th>Amount</th>
        <th>Crypto</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody class="divide-y divide-white/10">
        @foreach($deposits as $d)
        <tr>
        <td>{{ $d->user->email }}</td>
        <td>${{ $d->amount }}</td>
        <td>{{ ucfirst($d->method) }}</td>
        <td>{{ $d->status }}</td>

        @if($d->method==='crypto')
        <td>
        <a href="{{ asset('storage/'.$d->proof) }}" target="_blank">View Proof</a>
        </td>
        @endif

        <td>
        @if($d->status==='pending')
        <form method="POST" action="/admin/deposits/{{ $d->id }}/approve">@csrf<button>Approve</button></form>
        <form method="POST" action="/admin/deposits/{{ $d->id }}/reject">@csrf<button>Reject</button></form>
        @endif
        </td>
        </tr>
@endforeach


    </tbody>
</table>

</div>
@endsection
