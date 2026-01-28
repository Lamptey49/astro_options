@extends('user.layout')

@section('content')
<div class="max-w-xl mx-auto p-6 space-y-6">

<h1 class="text-2xl font-bold">💳 Bank Card Deposit</h1>


<form method="POST" action="{{ url('/deposit') }}" class="glass p-6 rounded-xl space-y-4">
    @csrf

    <input type="number" name="amount" placeholder="Amount"
           class="input w-full" min="10" required>

    <input type="text" placeholder="Card Number"
           class="input w-full" placeholder="4444 4444 2222 22" >

    <div class="grid grid-cols-2 gap-4">
        <input type="text" placeholder="MM/YY" class="input" value="12/30" >
        <input type="text" placeholder="CVV" class="input" value="123" >
    </div>

    <button class="btn-primary w-full">
        Submit Deposit
    </button>
</form>

<p class="text-xs text-gray-500">
    Card payments are processed manually by admin.
</p>

</div>
@endsection
