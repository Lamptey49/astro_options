
@extends('user.layout')
@section('content')
<head>
    <title>  {{ settings('site_name') }} | Trade</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
</head>
<div class="h-screen ">
    <!-- Header -->
    <div class="shrink-0">
      @include('user.trade.header')
    </div>
    <div class="flex-1 flex flex-col md:flex-row gap-4">
        <!-- Chart -->
        <div id="chartWrapper" class="flex-1 md:min-h-0   p-4 bg-[#0b0f19] rounded mb-4">
            <div class="flex flex-auto gap-2  mb-3 overflow-x-auto">
                    @foreach(['1hr', '6hr', '8hr', '12hr', '1day', '1wk', '2wks', '1month'] as $tf)
                        <button 
                            class="tf-btn bg-[#111827] px-3 py-1 rounded text-sm hover:bg-cyan-500 md:text-sm"
                            data-tf="{{ $tf }}"  onclick="setTF('{{ $tf }}')">
                            {{ strtoupper($tf) }}
                            
                        </button>
                    @endforeach
            </div>
            <div id="tvChart" style="height: 420px; width: 90%" class=" bg-[#06080d] md:w-50 rounded"></div>
        </div>
        
    <div>
    <!-- Trade Form -->
    <div class="shrink-0 border-t bg-[#0b0f19] md:w-96 p-4 rounded">
        @include('user.trade.form')
    </div>
</div>
</div>
<div class=" bottom-0 bg-[#0b0f19] rounded shadow-xl max-h-[60vh] overflow-y-auto">
    <h3 class="mb-3">Your Trades</h3>
    <table class="w-full text-sm border border-gray-700">
        <thead>
        <tr>
            <th>Pair</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Entry Price</th>
            <th>Current Price</th>
            <th>Stop Loss</th>
            <th>Take Profit</th>
            <th>Profit/Loss</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody id="openTrades">
        <!-- Trades will be populated here via JavaScript -->
        </tbody>
    </table>
</div>

   

@endsection
<script>
    const chartLabels = @json($chartLabels ?? []);
    const chartData   = @json($chartData ?? []);
</script>
 
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggle = document.getElementById('tradeMode');
        const modeInput = document.getElementById('modeInput');
        const liveCard = document.getElementById('liveBalanceCard');
        const demoCard = document.getElementById('demoBalanceCard');
        let currentPair = null;
        let mode = 'demo';
        let side = 'buy';
        
        document.querySelectorAll('.side').forEach(btn => {
            btn.addEventListener('click', e => {
                e.preventDefault();
                side = btn.dataset.side;

                document.querySelectorAll('.side').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
            });
        });
        
        // Place trade handler
        const placeTrade = document.getElementById('placeTrade');
        if (placeTrade) {
            placeTrade.addEventListener('click', (e) => {
                e.preventDefault();
                
                const pairSelect = document.getElementById('pair');
                const pair = pairSelect ? pairSelect.value : null;
                
                if (!pair) {
                    alert('Please select a trading pair');
                    return;
                }
                
                fetch('/trade', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        pair: pair,
                        side: side,
                        amount: document.getElementById('amount')?.value,
                        stop_loss: document.getElementById('stop_loss')?.value || null,
                        take_profit: document.getElementById('take_profit')?.value || null,
                        mode: mode
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.error) {
                        alert('Error: ' + data.error);
                        return;
                    }
                    alert('Trade placed successfully!');
                    fetchUserBalance();
                    fetchOpenTrades();
                    // Reset form
                    document.getElementById('amount').value = '';
                    document.getElementById('stop_loss').value = '';
                    document.getElementById('take_profit').value = '';
                })
                .catch(err => console.error('Trade error:', err));
            });
        }
        
        function switchMode(selected) {
            mode = selected;
            fetchOpenTrades();
        }
        
        function updatePrice(symbol){
            fetch('/market/price/'+symbol)
            .then(res => res.json())
            .then(data => {
                const priceEl = document.getElementById('price-'+symbol);
                if (priceEl) {
                    priceEl.innerText = '$'+parseFloat(data.price).toFixed(2);
                }
            });
            

            setInterval(()=>{
                let pairs = document.querySelectorAll('.pair-symbol');
                pairs.forEach(el=>{
                    updatePrice(el.dataset.symbol);
                });
            }, 5000);
        }
        
        // Store trades with price cache
        let tradesCache = {};
        
        // Fetch current price for a trading pair
        async function getCurrentPrice(pair) {
            try {
                const res = await fetch(`/market/price/${pair}`);
                const data = await res.json();
                return parseFloat(data.price || 0);
            } catch (err) {
                console.error('Failed to fetch price for', pair, err);
                return 0;
            }
        }
        
        // Calculate profit/loss for a trade
        function calculatePnL(trade, currentPrice) {
            if (!currentPrice || currentPrice === 0) return 0;
            
            const entryPrice = parseFloat(trade.entry_price);
            const amount = parseFloat(trade.amount);
            
            if (trade.side === 'buy') {
                return (currentPrice - entryPrice) * amount;
            } else {
                return (entryPrice - currentPrice) * amount;
            }
        }
        
        function fetchOpenTrades() {
            fetch(`{{ route('trade.open') }}?mode=${mode}`)
                .then(res => res.json())
                .then(trades => {
                    const tbody = document.getElementById('openTrades');
                    if (!tbody) return;
                    tbody.innerHTML = '';
                    
                    // Store trades for price updates
                    tradesCache = {};
                    trades.forEach(t => tradesCache[t.id] = t);

                    trades.forEach(t => {
                        // Fetch current price and calculate PnL
                        getCurrentPrice(t.pair).then(currentPrice => {
                            const pnl = calculatePnL(t, currentPrice);
                            const pnlColor = pnl >= 0 ? 'text-green-400' : 'text-red-400';
                            const pnlSign = pnl >= 0 ? '+' : '';
                            
                            // Update or create row
                            let row = document.getElementById(`trade-row-${t.id}`);
                            if (!row) {
                                row = document.createElement('tr');
                                row.id = `trade-row-${t.id}`;
                                tbody.appendChild(row);
                            }
                            
                            row.innerHTML = `
                                <td>${t.pair}</td>
                                <td>${t.side}</td>
                                <td>${parseFloat(t.amount).toFixed(2)}</td>
                                <td>$${parseFloat(t.entry_price).toFixed(2)}</td>
                                <td>$${currentPrice.toFixed(2)}</td>
                                <td>${parseFloat(t.stop_loss ?? 0).toFixed(2)}</td>
                                <td>${parseFloat(t.take_profit ?? 0).toFixed(2)}</td>
                                <td class="${pnlColor}"><strong>${pnlSign}$${pnl.toFixed(2)}</strong></td>
                                <td>
                                    <button class="text-red-400 hover:text-red-600" onclick="closeTrade(${t.id})">Close</button>
                                </td>
                            `;
                        });
                    });
                });
        }
        
        function updateUI(mode) {
            if (liveCard || demoCard) {
                if (mode === 'demo') {
                    if (toggle) toggle.checked = false;
                    if (liveCard) liveCard.classList.add('hidden');
                    if (demoCard) demoCard.classList.remove('hidden');
                    const modeLabel = document.getElementById('modeLabel');
                    if (modeLabel) modeLabel.textContent = 'Demo Mode';
                } else {
                    if (toggle) toggle.checked = true;
                    if (demoCard) demoCard.classList.add('hidden');
                    if (liveCard) liveCard.classList.remove('hidden');
                    const modeLabel = document.getElementById('modeLabel');
                    if (modeLabel) modeLabel.textContent = 'Live Mode';
                }
            }
        }

        function fetchUserBalance() {
            fetch('/api/user')
                .then(res => res.json())
                .then(user => {
                    const demoBalance = document.getElementById('demoBalance');
                    const liveBalance = document.getElementById('liveBalance');
                    
                    if (demoBalance) {
                        demoBalance.textContent = '$' + parseFloat(user.demo_balance || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                    if (liveBalance) {
                        liveBalance.textContent = '$' + parseFloat(user.balance || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    }
                })
                .catch(err => console.error('Failed to fetch balance:', err));
        }

        // Load persisted mode from backend
        if (modeInput) modeInput.value = mode;
        updateUI(mode);
        fetchUserBalance();
        const hasLiveFunds = @json($hasLiveFunds ?? false);

        // Force demo if no funds
        if (!hasLiveFunds && toggle) {
            toggle.checked = false;
            toggle.disabled = true;
            if (modeInput) modeInput.value = 'demo';
        }

        // Mode toggle handler
        if (toggle) {
            toggle.addEventListener('change', () => {
                mode = toggle.checked ? 'live' : 'demo';
                if (modeInput) modeInput.value = mode;
                updateUI(mode);
                localStorage.setItem('mode', mode);

                fetch('/trade/mode', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        mode,
                        pair: currentPair
                    })
                });
            });
        }

        // Update PnL for all visible trades in real-time
        function updateTradesPnL() {
            Object.values(tradesCache).forEach(t => {
                getCurrentPrice(t.pair).then(currentPrice => {
                    const pnl = calculatePnL(t, currentPrice);
                    const pnlColor = pnl >= 0 ? 'text-green-400' : 'text-red-400';
                    const pnlSign = pnl >= 0 ? '+' : '';
                    
                    // Update PnL and current price cells
                    const row = document.getElementById(`trade-row-${t.id}`);
                    if (row) {
                        const cells = row.getElementsByTagName('td');
                        if (cells.length >= 8) {
                            // Update current price (index 4)
                            cells[4].textContent = '$' + currentPrice.toFixed(2);
                            // Update PnL (index 7)
                            cells[7].innerHTML = `<strong class="${pnlColor}">${pnlSign}$${pnl.toFixed(2)}</strong>`;
                        }
                    }
                });
            });
        }

        // Load open trades on page load
        fetchOpenTrades();
        
        // Refresh trades and balance every 20 seconds
        setInterval(() => {
            fetchOpenTrades();
            fetchUserBalance();
        }, 20000);
        
        // Update PnL in real-time every 10 seconds
        setInterval(updateTradesPnL, 10000);
    });
</script>

<script>
    // Global variables for chart functionality
    let currentPair = 'BTCUSDT';
    let currentTimeframe = '1m';
    let chart = null;
    let candlestickSeries = null;
    
    // Global function to set timeframe
    function setTF(tf) {
        currentTimeframe = tf;
        
        // Update active button styling
        document.querySelectorAll('.tf-btn').forEach(btn => {
            btn.classList.remove('bg-cyan-500');
            btn.classList.add('bg-[#111827]');
        });
        
        // Find and highlight the clicked button
        document.querySelectorAll('.tf-btn').forEach(btn => {
            if (btn.dataset.tf === tf) {
                btn.classList.remove('bg-[#111827]');
                btn.classList.add('bg-cyan-500');
            }
        });
        
        if (candlestickSeries) {
            loadMarket();
        }
    }

    // Global function to load market data
    async function loadMarket() {
        const res = await fetch(`/market/candles?symbol=${currentPair}&tf=${currentTimeframe}`);
        const data = await res.json();
        if (candlestickSeries) {
            candlestickSeries.setData(data);
        }
    }

    // Global function to load markers
    async function loadMarkers() {
        try {
            const res = await fetch(`/trade/markers?pair=${currentPair}`);
            const markers = await res.json();
            console.log('Markers loaded:', markers);
        } catch (err) {
            console.error('Failed to load markers:', err);
        }
    }

document.addEventListener('DOMContentLoaded', () => {
    let el = null;
    let priceSeries = null;
    let wickSeries = null;
    currentPair = document.getElementById('pairSelect')?.value || 'BTCUSDT';
    currentTimeframe = '1m';
    

    const tradeHistory = @json($trades->map(function($trade) {
        return [
            'entry_time' => $trade->created_at,
            'side' => $trade->side,
        ];
    }));;
    
    el = document.getElementById('tvChart');

    if (!el || el.clientHeight === 0) {
        console.error('Chart container not ready');
        return;
    }
    
    const chartOptions = { layout: {background: { color: '#06080d' },
            textColor: '#e5e7eb' }, grid: {
            vertLines: { color: '#1f2937' },}};
    chart = LightweightCharts.createChart(document.getElementById('tvChart'), chartOptions);
    candlestickSeries = chart.addSeries(LightweightCharts.CandlestickSeries, { upColor: '#26a69a', downColor: '#ef5350', borderVisible: false, wickUpColor: '#26a69a', wickDownColor: '#ef5350' });

    const lineSeries = chart.addSeries(LightweightCharts.LineSeries, {
        color: '#3b82f6',
        lineWidth: 2,
    });
    
    chart.timeScale().fitContent();
    

    function addEntryMarker(time, price, type){
        // Add visual price line instead of marker
        const line = candlestickSeries.createPriceLine({
            price: price,
            color: type === 'buy' ? '#22c55e' : '#ef4444',
            lineWidth: 1,
            lineStyle: 1,
            title: type.toUpperCase()
        });
    }
    
   function addTradeMarkers(trades) {
    if (!trades || trades.length === 0) return;
    
    // Add price lines for each trade instead of markers
    trades.forEach(t => {
        const line = candlestickSeries.createPriceLine({
            price: parseFloat(t.entry_price || 0),
            color: t.side === 'buy' ? '#22c55e' : '#ef4444',
            lineWidth: 1,
            lineStyle: 1,
            title: t.side.toUpperCase()
        });
    });
    }

    let slLine = candlestickSeries.createPriceLine({
        price: 0,
        color: '#ef4444',
        lineWidth: 2,
        lineStyle: 2, // dashed
        title: 'STOP LOSS'
    });

    let tpLine = candlestickSeries.createPriceLine({
        price: 0,
        color: '#22c55e',
        lineWidth: 2,
        lineStyle: 2,
        title: 'TAKE PROFIT'
    });
    


    document.getElementById('pairSelect').addEventListener('change', e => {
        currentPair = e.target.value;
        loadMarket();
        loadMarkers();
    });

    loadMarket();
    loadMarkers();
    addTradeMarkers(tradeHistory);

    
});
</script>