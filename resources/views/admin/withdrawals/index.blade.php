@extends('admin.layout')

@section('content')

<h1 class="text-2xl mb-6">Withdrawal Requests</h1>

<table class="w-full">
<thead>
<tr>
    <th>User</th>
    <th>Amount</th>
    <th>Method</th>
    <th>Details</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@foreach($withdrawals as $w)
<tr>
    <td>{{ $w->user->email }}</td>
    <td>${{ $w->amount }}</td>
    <td>{{ $w->method }}</td>
    <td>
        {{ $w->wallet_address ?? $w->bank_name }}
    </td>
    <td>{{ $w->status }}</td>
    <td>
        @if($w->status === 'pending')
        <form method="POST" action="/admin/withdrawals/{{ $w->id }}/approve">
            @csrf
            <button class="btn-sm">Approve</button>
        </form>

        <form method="POST" action="/admin/withdrawals/{{ $w->id }}/reject">
            @csrf
            <button class="btn-danger">Reject</button>
        </form>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>

@endsection
