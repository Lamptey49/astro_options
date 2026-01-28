<div class="bg-[#06080d] p-4 rounded">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold">New Crypto Trade</h3>
        
        <!-- Mode Toggle Switch -->
        <div class="flex items-center gap-3">
            <span class="text-xs" id="modeLabel">Demo Mode</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="tradeMode" class="sr-only peer" />
                <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
            <span class="text-xs">Live Mode</span>
        </div>
    </div>

    <!-- Balance Display -->
    <div class="grid grid-cols-2 gap-2 mb-4">
        <div id="demoBalanceCard" class="bg-[#0b0f19] p-3 rounded border border-green-600/30">
            <div class="text-xs text-gray-400">Demo Balance</div>
            <div class="text-lg font-bold text-green-400" id="demoBalance">$10,000.00</div>
        </div>
        <div id="liveBalanceCard" class="bg-[#0b0f19] p-3 rounded border border-blue-600/30 hidden">
            <div class="text-xs text-gray-400">Live Balance</div>
            <div class="text-lg font-bold text-blue-400" id="liveBalance">$0.00</div>
        </div>
    </div>

    <form method="POST" action="{{ route('trade.store') }}" >
        @csrf
        <input type="hidden" id="modeInput" name="mode" value="demo" />
        
        <div class="grid grid-cols-2 gap-3">
            <button type="button" class="w-1/2 bg-green-600 py-4 text-white side buy" data-side="buy">BUY</button>
            <button type="button" class="w-1/2 bg-red-600 py-4 text-white side sell" data-side="sell">SELL</button>
        </div>
        
        <div class="mb-4">
            <label for="pair_select" class="block mb-1 text-sm">Trading Pair</label>
            <select class="w-full bg-[#0b0f19] p-2 rounded border border-gray-700" name="pair" id="pair">
                @foreach($pairs as $pair)
                    <option value="{{ $pair->binance_symbol }}">{{ $pair->symbol }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="amount" class="block mb-1 text-sm">Amount ($)</label>
            <input type="number" name="amount" id="amount" min="10" step="0.01"
                class="w-full bg-[#0b0f19] p-2 rounded border border-gray-700"
                placeholder="Enter amount to trade" required>
        </div> 
        
        <div class="grid grid-cols-2 gap-3">
            <div class="mb-4">
                <label for="stop_loss" class="block mb-1 text-sm">Stop Loss (%)</label>
                <input type="number" name="stop_loss" id="stop_loss" min="0" step="0.01"
                    class="w-full bg-[#0b0f19] p-2 rounded border border-gray-700"
                    placeholder="Enter stop loss percentage">   
            </div>
            <div class="mb-4">           
                <label for="take_profit" class="block mb-1 text-sm">Take Profit (%)</label>
                <input type="number" name="take_profit" id="take_profit" min="0" step="0.01"
                    class="w-full bg-[#0b0f19] p-2 rounded border border-gray-700"
                    placeholder="Enter take profit percentage">  
            </div>
        </div>
        <button type="submit" class="btn btn-danger w-full" id="placeTrade">Place Trade</button>
    </form>
</div>

