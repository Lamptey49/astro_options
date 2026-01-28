






<div class="flex flex-1  gap-4 bg-[#0b0f19] p-4 border-b border-gray-800">
    <div class="flex-auto p-4">
        <div class="flex flex-auto gap-2 mb-3">
            @foreach(['1hr', '6hr', '8hr', '12hr', '1day', '1wk', '2wks', '1month'] as $tf)
                <button
                    class="tf-btn bg-[#111827] px-3 py-1 rounded text-sm hover:bg-cyan-500"
                    data-tf="{{ $tf }}">
                    {{ strtoupper($tf) }}
                </button>
            @endforeach
        </div>
        <div id="tvChart" style="height: 420px; width: 90%" class=" bg-[#06080d] rounded"></div>
        
    </div>
    <div class="flex   bg-[#06080d] p-4 space-y-4 border-l border-gray-800">
        <div class=" bg-[#0b0f19] p-4 rounded">
            <div class=" justify-between text-sm">
                @if(auth()->user()->mode === 'demo')
                <span>Demo Balance: ${{ auth()->user()->demo_balance }}</span>
                <span class="bg-yellow-500 text-black px-2 rounded">Demo</span>
                
                @else
                <span>Balance: ${{ auth()->user()->balance }}</span>
                <span class="bg-green-500 text-black px-2 rounded">LIVE</span>
            </div>
           
            @endif
           

            <div class="flex items-center gap-4 mb-4 {{ !$hasLiveFunds ? 'opacity-50 cursor-not-allowed' : '' }}">
            <span id="liveLabel" class="font-semibold text-green-500">LIVE</span>

            <label class="relative  items-center cursor-pointer">
                <input type="checkbox" id="mode" name="mode" class="sr-only peer"
            {{ $mode === 'demo' ? 'checked' : '' }}
            {{ !$hasLiveFunds ? 'disabled' : '' }}>

                <input type="hidden" name="mode" id="modeInput" value="{{ $mode }}">
                <div class="w-14 h-8 bg-gray-700 rounded-full peer 
                            peer-checked:bg-blue-600
                            after:content-['']
                            after:absolute after:top-1 after:left-1
                            after:w-6 after:h-6 after:bg-white
                            after:rounded-full after:transition-all
                            peer-checked:after:translate-x-6">
                </div>
            </label>
            <span id="demoLabel" class="font-semibold text-gray-400">DEMO</span>

            <input type="hidden" name="mode" id="liveBtn" value="live">
        </div>
        </div>

        <div class="grid grid-cols-2 gap-3">
             <div class="mode-toggle">
            <button id="demoBtn" class="active">Demo</button>
            <button id="liveBtn">Live</button>
        </div>

        <div class="rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 p-4 text-white">
        <p class="text-xs opacity-80">Available Balance</p>
        <h2 class="text-2xl font-bold">${{ number_format(auth()->user()->balance,2) }}</h2>
        </div>

        </div>
        
    </div>
</div>
@endsection




