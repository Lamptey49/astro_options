@extends('admin.layout')

@section('content')
<h1 class="text-3xl font-bold mb-6">Transactions</h1>

<!-- Filters -->
<form method="GET" class="flex gap-4 mb-6">
    <select name="type" class="input">
        <option value="">All Types</option>
        <option value="deposit" {{ request('type')=='deposit'?'selected':'' }}>Deposit</option>
        <option value="withdrawal" {{ request('type')=='withdrawal'?'selected':'' }}>Withdrawal</option>
    </select>

    <select name="status" class="input">
        <option value="">All Status</option>
        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
        <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
        <option value="rejected" {{ request('status')=='rejected'?'selected':'' }}>Rejected</option>
    </select>

    <button class="px-4 py-2 bg-indigo-600 rounded">
        Filter
    </button>
</form>

<table class="w-full bg-white/5 rounded-xl">
<thead class="bg-white/10">
<tr>
    <th class="p-4">User</th>
    <th>Type</th>
    <th>Amount</th>
    <th>Hash</th>
    <th>Status</th>
    <th>Date</th>
    <th class="text-right p-4">Action</th>
</tr>
</thead>

<tbody>
@foreach($transactions as $tx)
<tr class="border-t border-white/10">
    <td class="p-4">{{ $tx->user->email }}</td>
    <td>{{ ucfirst($tx->type) }}</td>
    <td>${{ number_format($tx->amount,2) }}</td>
    <td>{{ $tx->tx_hash }}</td>
    <td>
        <span class="
            {{ $tx->status=='approved'?'text-green-400':'' }}
            {{ $tx->status=='pending'?'text-yellow-400':'' }}
            {{ $tx->status=='rejected'?'text-red-400':'' }}
        ">
            {{ ucfirst($tx->status) }}
        </span>
    </td>
    <td>{{ $tx->created_at->format('d M Y') }}</td>

    <td class="p-4 text-right">
        @if($tx->isPending())
        <div class="flex gap-2 justify-end">
            <form method="POST" action="/admin/transactions/{{ $tx->id }}/approve">
                @csrf @method('PATCH')
                <button class="px-3 py-1 bg-green-600 rounded">Approve</button>
            </form>

            <form method="POST" action="/admin/transactions/{{ $tx->id }}/reject">
                @csrf @method('PATCH')
                <button class="px-3 py-1 bg-red-600 rounded">Reject</button>
            </form>
        </div>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

<div class="mt-6">
    {{ $transactions->links() }}
</div>
@endsection
