@extends('user.layout')

@section('content')
<div class="max-w-4xl mx-auto p-6 space-y-8">

<h1 class="text-2xl font-bold">🪙 Crypto Deposit</h1>
<p class="text-gray-400 text-sm">
    Select cryptocurrency, enter amount, and complete payment within 30 minutes.
</p>
{{-- STEP 1: FORM --}}
<div class="glass p-6 rounded-xl space-y-4">
    <form method="POST" action="{{ route('deposit.store') }}">
        @csrf
    <div>
        <label class="text-sm">Deposit Amount ($)</label>
        <input type="number" id="amount" name="amount" class="input w-full"
               min="10" placeholder="Enter amount">
    </div>

    <div>
        <label class="text-sm">Select Cryptocurrency</label>
        <select id="crypto" name='crypto' class="input w-full">
            <option value="">-- Choose Crypto --</option>
            <option value="btc">Bitcoin (BTC)</option>
            <option value="eth">Ethereum (ETH)</option>
            <option value="usdt">USDT (TRC20)</option>
        </select>
    </div>
    <input type="hidden" name="currency" value="dollar">
    <div>
        <label class="text-sm">Transaction Hash</label>
    <input type="text" class="input w-full" name="hash" placeholder="Transaction Hash" required>
    </div>
    <div>
        <button type="button" onclick="confirmPayment()" class="btn-primary w-full">
            Confirm Payment
        </button>
    </div>
  
    </div>

    {{-- STEP 2: PAYMENT DETAILS --}}
    <div id="paymentBox" class="glass p-6 rounded-xl hidden space-y-4">

        <h2 class="text-lg font-semibold">📌 Payment Details</h2>

        <p>
            Amount: <strong>$<span id="displayAmount"></span></strong><br>
            Crypto: <strong><span id="displayCrypto"></span></strong>
        </p>

        <img id="qrCode" class="qr mx-auto">

        <div class="address" id="walletAddress"></div>

        <button onclick="copyAddress()" class="btn-secondary w-full">
            Copy Wallet Address
        </button>

        <div class="text-center mt-4">
            ⏳ Time remaining: <span id="timer" class="font-bold text-red-400"></span>
        </div>

        <button type="submit" class="btn btn-primary">I have Made Payment</button>
    </div>
  </form> 

</div>

@endsection

<script>
function copyText(id) {
    const text = document.getElementById(id).innerText;
    navigator.clipboard.writeText(text);
    alert('Wallet address copied!');
}
</script>

</script>
<script>
let countdown;

function confirmPayment() {
    const amount = document.getElementById('amount').value;
    const crypto = document.getElementById('crypto').value;

    if (!amount || amount < 10 || !crypto) {
        alert('Please enter a valid amount and select crypto');
        return;
    }

    const wallets = {
        btc: {
            name: 'Bitcoin (BTC)',
            address: 'bc1qexamplebtcaddress'
        },
        eth: {
            name: 'Ethereum (ETH)',
            address: '0xExampleETHAddress'
        },
        usdt: {
            name: 'USDT (TRC20)',
            address: 'TExampleUSDTAddress'
        }
    };

    const selected = wallets[crypto];

    document.getElementById('displayAmount').innerText = amount;
    document.getElementById('displayCrypto').innerText = selected.name;
    document.getElementById('walletAddress').innerText = selected.address;

    document.getElementById('qrCode').src =
        `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${selected.address}`;

    document.getElementById('paymentBox').classList.remove('hidden');

    startTimer(30 * 60);
}

function copyAddress() {
    const address = document.getElementById('walletAddress').innerText;
    navigator.clipboard.writeText(address);
    alert('Wallet address copied');
}

function startTimer(seconds) {
    clearInterval(countdown);

    let time = seconds;
    const timerEl = document.getElementById('timer');

    countdown = setInterval(() => {
        const minutes = Math.floor(time / 60);
        const secs = time % 60;

        timerEl.innerText = `${minutes}:${secs < 10 ? '0' : ''}${secs}`;

        if (time <= 0) {
            clearInterval(countdown);
            timerEl.innerText = 'Expired';
            alert('Payment session expired. Please start again.');
        }

        time--;
    }, 1000);
}
</script>