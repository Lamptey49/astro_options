
<?php $__env->startSection('content'); ?>
<head>
    <title>  <?php echo e(settings('site_name')); ?> | Investments</title>
   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link rel="icon" href="<?php echo e(asset('storage/' . settings('favicon'))); ?>" type="image/x-icon"/>
</head>
<div class="max-w-4xl mx-auto p-6 space-y-8">
    <h1 class="text-2xl font-bold">💼 Investments</h1>
    <p class="text-gray-400 text-sm">
        View and manage your investment plans.
    </p>

    <h3>Select Investment Plan</h3>
    <div class="grid md:grid-cols-3 gap-8">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="relative bg-gradient-to-br from-indigo-600/20 to-purple-600/10 p-6 rounded-2xl border border-white/10 hover:scale-105 transition">

            <h3 class="text-xl font-bold mb-2"><?php echo e($plan->name); ?></h3>

            <ul class="text-sm text-gray-300 space-y-2 mb-6">
                <li>ROI: <strong><?php echo e($plan->roi_percent); ?>%</strong></li>
                <li>Duration: <?php echo e($plan->duration_days); ?> days</li>
                <li>Min: $<?php echo e($plan->min_amount); ?></li>
                <li>Max: $<?php echo e($plan->max_amount); ?></li>
            </ul>

            <form method="POST" action="/invest">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="plan_id" value="<?php echo e($plan->id); ?>">
                <input type="hidden" name="amount" value="0"
                    class="w-full mb-4 bg-black/50 border border-white/10 rounded px-4 py-2">

                <button class="w-full py-2 rounded bg-gradient-to-r from-indigo-500 to-purple-500 font-semibold hover:opacity-90">
                   Contact Support to Buy/Upgrade Plan
                </button>
            </form>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <h4>My Active Investments</h4>

    <?php $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="investment-card">

        <p>Plan: <?php echo e($investment->plan->name); ?></p>
        <p>Amount: $<?php echo e(number_format($investment->amount,2)); ?></p>
        <p>Expected Return: $<?php echo e(number_format($investment->expected_return,2)); ?></p>
        <p>Status: <?php echo e(ucfirst($investment->status)); ?></p>

        <div class="progress-container">
            <div class="progress-bar" style="width: <?php echo e($investment->progress); ?>%">
                <?php echo e($investment->progress); ?>%
            </div>
        </div>
        <?php if($investment->status === 'active' && $investment->progress < 30): ?>
        <form method="POST" action="/investment/<?php echo e($investment->id); ?>/cancel">
        <?php echo csrf_field(); ?>
        <button class="cancel-btn">Cancel Investment</button>
        </form>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      

<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/user/investments/index.blade.php ENDPATH**/ ?>