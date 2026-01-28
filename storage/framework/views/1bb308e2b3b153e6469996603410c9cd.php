
<?php $__env->startSection('content'); ?>
<head>
    <title>  <?php echo e(settings('site_name')); ?> | Withdrawals</title>
   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="icon" href="<?php echo e(asset('storage/' . settings('favicon'))); ?>" type="image/x-icon"/>
</head>
<h1 class="text-2xl mb-6">Withdraw Funds</h1>

<?php if(session('success')): ?>
    <p class="text-green-400 mb-4"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<form method="POST" class="card mb-8">
<?php echo csrf_field(); ?>

<label>Amount</label>
<input name="amount" class="input" required>

<label class="mt-3">Method</label>
<select name="method" id="method" class="input">
    <option value="crypto">Crypto</option>
    <option value="bank">Bank</option>
</select>

<div id="cryptoFields" class="mt-3">
    <label>Wallet Address</label>
    <input name="wallet_address" class="input">
</div>

<div id="bankFields" class="mt-3 hidden">
    <label>Bank Name</label>
    <input name="bank_name" class="input">

    <label class="mt-2">Account Number</label>
    <input name="account_number" class="input">
</div>

<?php if(auth()->user()->balance <= 0): ?>
    <button disabled class="btn btn-secondary">
        Insufficient Balance
    </button>
<?php else: ?>
    <button class="btn btn-danger">Withdraw</button>
<?php endif; ?>

</form>

<h3>Your Withdrawals</h3>
<table class="w-full">
<thead>
<tr>
    <th>Amount</th>
    <th>Method</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>
<tbody>
<?php $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td>$<?php echo e($w->amount); ?></td>
    <td><?php echo e(ucfirst($w->method)); ?></td>
    <td><?php echo e(ucfirst($w->status)); ?></td>
    <td><?php echo e($w->created_at->format('d M Y')); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>

<script>
document.getElementById('method').addEventListener('change', e => {
    document.getElementById('cryptoFields').style.display =
        e.target.value === 'crypto' ? 'block' : 'none';
    document.getElementById('bankFields').style.display =
        e.target.value === 'bank' ? 'block' : 'none';
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/user/withdrawals/index.blade.php ENDPATH**/ ?>