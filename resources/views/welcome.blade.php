@extends('layouts.app')

@section('content')

<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 via-purple-600/10 to-transparent"></div>

    <div class="relative z-10 text-center py-32">
        <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-6">
            Invest Smarter in <span class="text-indigo-400">Digital Assets</span>
        </h1>

        <p class="max-w-2xl mx-auto text-gray-300 text-lg mb-10">
            A secure and intelligent investment platform for crypto and digital markets.
            Grow your wealth with confidence.
        </p>

        <div class="flex gap-4 items-center">
</div>

    </div>
</section>
<section class="py-20">
    <div class="grid md:grid-cols-4 gap-8 text-center">

        <div class="stat-card" data-target="10000">
            <h3 class="counter text-3xl font-bold text-indigo-400">0</h3>
            <p class="text-gray-400">Active Investors</p>
        </div>

        <div class="stat-card" data-target="5000000">
            <h3 class="counter text-3xl font-bold text-indigo-400">0</h3>
            <p class="text-gray-400">Total Investments ($)</p>
        </div>

        <div class="stat-card" data-target="99">
            <h3 class="counter text-3xl font-bold text-indigo-400">0</h3>
            <p class="text-gray-400">Uptime (%)</p>
        </div>

        <div class="stat-card" data-target="24">
            <h3 class="counter text-3xl font-bold text-indigo-400">0</h3>
            <p class="text-gray-400">Support Hours</p>
        </div>

    </div>
</section>
<section class="py-24 bg-[#0b0f1a] text-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <h2 class="text-4xl font-bold mb-4">
                Live Market Prices
            </h2>
            <p class="text-gray-400">
                Track real-time US stocks and crypto assets
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Crypto Market -->
            <div class="bg-[#0f172a] rounded-2xl p-6 shadow-xl">
                <h3 class="text-xl font-semibold mb-4">Crypto Market</h3>

                <div class="tradingview-widget-container">
                    <div id="crypto-chart" style="height: 400px;"></div>
                </div>
            </div>

            <!-- US Stocks -->
            <div class="bg-[#0f172a] rounded-2xl p-6 shadow-xl">
                <h3 class="text-xl font-semibold mb-4">US Stock Market</h3>

                <div class="tradingview-widget-container">
                    <div id="stocks-chart" style="height: 400px;"></div>
                </div>
            </div>
<div id="stocks-chart" style="height: 400px;"></div>
        </div>
    </div>
</section>
<section class="py-24">
    <h2 class="text-4xl font-bold text-center mb-16">
        Why Choose <span class="text-indigo-400">{{settings('site_name')}}</span>
    </h2>

    <div class="grid md:grid-cols-3 gap-10">
        @foreach([
            ['Secure Platform','Advanced encryption and account protection'],
            ['Automated ROI','Daily profit calculation with transparency'],
            ['Crypto Payments','USDT & Bitcoin supported']
        ] as [$title,$desc])
        <div class="bg-white/5 p-8 rounded-2xl border border-white/10 hover:scale-105 transition">
            <h3 class="text-xl font-semibold mb-4">{{ $title }}</h3>
            <p class="text-gray-400">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</section>
<section class="py-24 bg-black/30 rounded-3xl">
    <h2 class="text-4xl font-bold text-center mb-16">
        Investment Plans
    </h2>

    <div class="grid md:grid-cols-3 gap-8">
        @foreach([
            ['Starter','10%','7 Days'],
            ['Advanced','25%','14 Days'],
            ['Premium','50%','30 Days']
        ] as [$name,$roi,$duration])
        <div class="bg-gradient-to-br from-indigo-600/20 to-purple-600/10 p-8 rounded-2xl border border-white/10">
            <h3 class="text-2xl font-bold mb-4">{{ $name }}</h3>
            <p class="text-gray-300 mb-2">ROI: <strong>{{ $roi }}</strong></p>
            <p class="text-gray-300 mb-6">Duration: {{ $duration }}</p>

            <a href="/register"
               class="block text-center py-3 rounded bg-indigo-600 hover:bg-indigo-500">
                Start Investing
            </a>
        </div>
        @endforeach
    </div>
</section>
<section class="py-24">
    <div class="grid md:grid-cols-2 gap-16 items-center">
        <div>
            <h2 class="text-4xl font-bold mb-6">
                Security & Transparency
            </h2>
            <p class="text-gray-400 mb-6">
                We prioritize security, transparency, and user trust.
                All transactions are monitored and manually verified.
            </p>
            <ul class="space-y-3 text-gray-300">
                <li>✔ Encrypted Transactions</li>
                <li>✔ Manual Withdrawal Approval</li>
                <li>✔ Real-Time Account Monitoring</li>
            </ul>
        </div>

        <div class="bg-white/5 p-10 rounded-2xl border border-white/10">
            <h3 class="text-xl font-semibold mb-4">Platform Highlights</h3>
            <p class="text-gray-400">
                Built with Laravel, modern UI, and scalable architecture.
            </p>
        </div>
    </div>
</section>
<section class="py-32 text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600/20 to-purple-600/20"></div>

    <div class="relative z-10">
        <h2 class="text-5xl font-extrabold mb-6">
            Start Growing Your Wealth Today
        </h2>
        <p class="text-gray-300 mb-10 max-w-xl mx-auto">
            Join thousands of investors using CryptoInvest to grow smarter.
        </p>

        <a href="/register"
           class="px-10 py-4 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
            Create Free Account
        </a>
    </div>
</section>

@endsection
