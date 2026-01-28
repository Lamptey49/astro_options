@extends('user.layout')
@section('content')
<head>
    <title>  {{ settings('site_name') }} | Withdrawals</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
</head>
<h1 class="text-2xl mb-6">Withdraw Funds</h1>

@if(session('success'))
    <p class="text-green-400 mb-4">{{ session('success') }}</p>
@endif

<form method="POST" class="card mb-8">
@csrf

<label>Amount</label>
<input name="amount" class="input" required>

<label class="mt-3">Method</label>
<select name="method" id="method" class="input">
    <option value="crypto">Crypto</option>
    <option value="bank">Bank</option>
</select>

<div id="cryptoFields" class="mt-3">
    <label>Wallet Address</label>
    <input name="wallet_address" class="input">
</div>

<div id="bankFields" class="mt-3 hidden">
    <label>Bank Name</label>
    <input name="bank_name" class="input">

    <label class="mt-2">Account Number</label>
    <input name="account_number" class="input">
</div>

@if(auth()->user()->balance <= 0)
    <button disabled class="btn btn-secondary">
        Insufficient Balance
    </button>
@else
    <button class="btn btn-danger">Withdraw</button>
@endif

</form>

<h3>Your Withdrawals</h3>
<table class="w-full">
<thead>
<tr>
    <th>Amount</th>
    <th>Method</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
@foreach($withdrawals as $w)
<tr>
    <td>${{ $w->amount }}</td>
    <td>{{ ucfirst($w->method) }}</td>
    <td>{{ ucfirst($w->status) }}</td>
    <td>{{ $w->created_at->format('d M Y') }}</td>
</tr>
@endforeach
</tbody>
</table>

<script>
document.getElementById('method').addEventListener('change', e => {
    document.getElementById('cryptoFields').style.display =
        e.target.value === 'crypto' ? 'block' : 'none';
    document.getElementById('bankFields').style.display =
        e.target.value === 'bank' ? 'block' : 'none';
});
</script>

@endsection
