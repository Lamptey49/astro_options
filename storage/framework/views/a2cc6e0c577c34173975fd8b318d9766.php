
<h1 class="text-2xl mb-6">📊 Crypto Trading</h1>

<?php if(session('success')): ?>
    <p class="text-green-400 mb-4"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<div class="flex items-center justify-between bg-[#0b0f19] p-4 border-b border-gray-800">
    <div class="flex items-center gap-3">
        <span class="bg-orange-500 p-2 rounded-full">
             <img src="<?php echo e(asset('storage/images/default-crypto.png')); ?>" width="30">
        </span>
        <select class="bg-[#111827] px-3 py-1 rounded text-sm" id="pairSelect">
            <?php $__currentLoopData = $pairs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pair): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($pair->binance_symbol); ?>">
            <?php echo e($pair->symbol); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>


    <div class="flex gap-6 text-sm hidden md:inline-flex">
        <div>Price<br><span class="text-cyan-400">$94,962.71</span></div>
        <div>24h<br><span class="text-green-400">+3.19%</span></div>
        <div>High<br><span class="text-green-400">$96,506</span></div>
        <div>Low<br><span class="text-red-400">$91,770</span></div>
    </div>
</div>
<?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/user/trade/header.blade.php ENDPATH**/ ?>