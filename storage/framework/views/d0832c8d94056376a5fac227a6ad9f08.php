

<?php $__env->startSection('content'); ?>
<div class="p-6">

<h1 class="text-2xl font-bold mb-6">🪙 Crypto Deposit Confirmations</h1>

<?php if(session('success')): ?>
    <p class="text-green-400 mb-4"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<table class="w-full bg-white/5 rounded overflow-hidden">
    <form method="GET">
        <select class="status input" name="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <button class="btn btn-primary" type="submit">Filter</button>
    </form>

    <thead class="bg-white/10">
    <tr>
        <th class="p-4 text-left">User</th>
        <th>Amount</th>
        <th>Crypto</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    </thead>

    <tbody class="divide-y divide-white/10">
        <?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
        <td><?php echo e($d->user->email); ?></td>
        <td>$<?php echo e($d->amount); ?></td>
        <td><?php echo e(ucfirst($d->method)); ?></td>
        <td><?php echo e($d->status); ?></td>

        <?php if($d->method==='crypto'): ?>
        <td>
        <a href="<?php echo e(asset('storage/'.$d->proof)); ?>" target="_blank">View Proof</a>
        </td>
        <?php endif; ?>

        <td>
        <?php if($d->status==='pending'): ?>
        <form method="POST" action="/admin/deposits/<?php echo e($d->id); ?>/approve"><?php echo csrf_field(); ?><button>Approve</button></form>
        <form method="POST" action="/admin/deposits/<?php echo e($d->id); ?>/reject"><?php echo csrf_field(); ?><button>Reject</button></form>
        <?php endif; ?>
        </td>
        </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    </tbody>
</table>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/crypto/index.blade.php ENDPATH**/ ?>