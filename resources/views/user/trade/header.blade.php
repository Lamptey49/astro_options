
<h1 class="text-2xl mb-6">📊 Crypto Trading</h1>

@if(session('success'))
    <p class="text-green-400 mb-4">{{ session('success') }}</p>
@endif

<div class="flex items-center justify-between bg-[#0b0f19] p-4 border-b border-gray-800">
    <div class="flex items-center gap-3">
        <span class="bg-orange-500 p-2 rounded-full">
             <img src="{{  asset('storage/images/default-crypto.png') }}" width="30">
        </span>
        <select class="bg-[#111827] px-3 py-1 rounded text-sm" id="pairSelect">
            @foreach($pairs as $pair)
            <option value="{{ $pair->binance_symbol }}">
            {{ $pair->symbol }}
            </option>
            @endforeach
        </select>
    </div>


    <div class="flex gap-6 text-sm hidden md:inline-flex">
        <div>Price<br><span class="text-cyan-400">$94,962.71</span></div>
        <div>24h<br><span class="text-green-400">+3.19%</span></div>
        <div>High<br><span class="text-green-400">$96,506</span></div>
        <div>Low<br><span class="text-red-400">$91,770</span></div>
    </div>
</div>
