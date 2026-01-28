

<?php $__env->startSection('content'); ?>

<h3 class="text-2xl mb-6 text-white">Make a Deposit</h3>
<div class="flex justify-center mt-6">
    <div class="card">
        <div class="card-body">
        <div class="tabs justify-center mb-4">
        <button class="tab-button bg-[#f4f4f4] tab-button-active text-white" onclick="showTab('crypto')">Crypto</button>
        <button class="tab-button tab-button-inactive text-white" onclick="showTab('card')">Bank Card</button>
    </div>
    <div id="paymentBox" class="glass p-6 rounded-xl space-y-4">
       <h2 class="text-lg font-semibold">📌  Payment Details</h2>
       
        <p>Pay:</p>
        <select id="cryptoSelect" onchange="updatePaymentDetails()" class="input w-full mb-4">
            <option value="btc">Bitcoin (BTC)</option>
            <option value="eth">Ethereum (ETH)</option>
            <option value="usdt">USDT (TRC20)</option>
        </select>
        <div class="address" id="walletAddress">
            </div>
            <!-- <button onclick="copyText('walletAddress')" class="btn-secondary btn-sm mb-2">Copy Address</button> -->
        <img id="qrCode" class="qr mx-auto">
    </div>
</div>

<!-- CRYPTO -->
<div id="crypto" class="tab">
<form method="POST" action="<?php echo e(route('deposit.crypto')); ?>" enctype="multipart/form-data">
<?php echo csrf_field(); ?>
<div class="form-group">
<label class="block text-sm font-medium mb-1" for="amount">Amount (USD):</label>
<input class="input w-full" type="number" name="amount" placeholder="Amount" required>
</div>
<div class="form-group">
    <label class="block text-sm font-medium mb-1" for="currency">Currency:</label>
<select class="input w-full" name="currency">
    <option value="BTC">Bitcoin</option>
    <option value="USDT">USDT</option>
</select>
</div>

<div class="form-group">
    <label class="block text-sm font-medium mb-1" for="tx_hash">Transaction Hash:</label>
<input class="input w-full" type="text" name="tx_hash" placeholder="Transaction Hash" required>
</div>
<div class="form-group">
    <label class="block text-sm font-medium mb-1" for="proof">Upload Deposit Proof:</label>
    <input class="input w-full" type="file" name="proof" required>
</div>
<div class="form-group">
<button class="btn btn-primary">Make Deposit</button>
</div>
</form>
</div>

<!-- CARD -->
<div id="card" class="tab" style="display:none;">
<form method="POST" action="<?php echo e(route('deposit.card')); ?>">
<?php echo csrf_field(); ?>
<div>
<label class="block text-sm font-medium mb-1" for="amount">Amount (USD):</label>
<input class="input w-full" type="number" name="amount" placeholder="Amount" required>
</div>
<div>
<button class="btn btn-primary">Pay with Card</button>
</div>
</form>
</div>
    </div>
</div>


<script>
function showTab(tab){
    document.getElementById('crypto').style.display = tab==='crypto'?'block':'none';
    document.getElementById('card').style.display = tab==='card'?'block':'none';
     // Hide payment box and QR code when card tab is selected
    const paymentBox = document.getElementById('paymentBox');
    if (tab === 'card') {
        paymentBox.style.display = 'none';
    } else {
        paymentBox.style.display = 'block';
    }
}

function copyText(id) {
    const text = document.getElementById(id).innerText;
    navigator.clipboard.writeText(text);
    alert('Wallet address copied!');
}

function updatePaymentDetails() {
    const wallets = {
        btc: {
            name: 'Bitcoin (BTC)',
            address: "<?php echo e(settings('btc_address')); ?>"
        },
        eth: {
            name: 'Ethereum (ETH)',
            address: "<?php echo e(settings('eth_address')); ?>"
        },
        usdt: {
            name: 'USDT (TRC20)',
            address: "<?php echo e(settings('usdt_trc20')); ?>"
        }
    };
    
    const crypto = document.getElementById('cryptoSelect').value;
    const selected = wallets[crypto];
    
    if (selected && selected.address) {
        document.getElementById('walletAddress').innerText = selected.address;
        document.getElementById('qrCode').src = 
            `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(selected.address)}`;
    } else {
        document.getElementById('walletAddress').innerText = 'Address not configured';
    }
}

// Call on page load
document.addEventListener('DOMContentLoaded', updatePaymentDetails);
</script>
<div class="mt-6 text-center text-sm text-gray-400">
    <p>Please allow up to 30 minutes for your deposit to be confirmed on the blockchain.</p>
    <p>If you encounter any issues, click on Chat for support 👉.</p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/wallet/deposit.blade.php ENDPATH**/ ?>