@extends('admin.layout')

@section('content')
<div class="p-6 space-y-8">

<h1 class="text-2xl font-bold">📊 Crypto Deposit Analytics</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="card">
        <h4>Total Approved Deposits</h4>
        <p class="value">${{ number_format($totalDeposits, 2) }}</p>
    </div>

    <div class="card">
        <h4>Total Transactions</h4>
        <p class="value">{{ $totalCount }}</p>
    </div>
</div>

<div class="glass p-6 rounded-xl">
    <h3 class="mb-4 font-semibold">Deposits by Cryptocurrency</h3>
    <canvas id="cryptoChart"></canvas>
</div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('cryptoChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: @json($byCrypto->pluck('crypto_type')),
        datasets: [{
            data: @json($byCrypto->pluck('total'))
        }]
    }
});
</script>
@endsection
