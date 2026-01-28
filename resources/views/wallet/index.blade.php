@extends('user.layout')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-8">

<h1 class="text-2xl font-bold">💼 Wallet</h1>

<div class="grid grid-cols-2 gap-6">
    <div class="card">
        <h4>Available Balance</h4>
    
    </div>
</div>

@include('wallet.deposit')

</div>
@endsection
