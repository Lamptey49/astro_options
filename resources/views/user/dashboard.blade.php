@extends('user.layout')

@section('content')

<h1 class="text-2xl mb-6">Account Overview</h1>

<div class="cards">
    <div class="card">
        <h4>Balance</h4>
        <p class="text-xl">${{ number_format(auth()->user()->balance,2) }}</p>
    </div>

    <div class="card">
        <h4>Total Invested</h4>
        <p class="text-xl">${{ number_format($totalInvested,2) }}</p>
    </div>

    <div class="card">
        <h4>Active Plans</h4>
        <p class="text-xl">{{ $activePlans }}</p>
    </div>

    <div class="card">
        <h4>Profit</h4>
        <p class="text-xl">${{ number_format($profit,2) }}</p>
    </div>
</div>

<div class="card mt-8">
    <h3 class="mb-4">Investment History</h3>
    <canvas id="investmentChart"></canvas>
</div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('investmentChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            data: {!! json_encode($chartData) !!},
            fill: false,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endsection
