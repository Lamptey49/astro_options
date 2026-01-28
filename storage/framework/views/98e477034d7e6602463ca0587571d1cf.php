
<?php $__env->startSection('content'); ?>
<div class="max-w-4xl">
    <h1 class="text-2xl font-bold mb-6">Site Settings</h1>
    
    <?php if($errors->any()): ?>
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.settings.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">General Settings</h2>
            
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Site Name</label>
                <input type="text" name="site_name" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['site_name'] ?? ''); ?>" required />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Site Email</label>
                <input type="email" name="site_email" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['site_email'] ?? ''); ?>" required />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Contact Phone</label>
                <input type="tel" name="contact_phone" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['contact_phone'] ?? ''); ?>" />    
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Cryptocurrency Addresses</h2>
            
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Bitcoin Address</label>
                <input type="text" name="btc_address" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['btc_address'] ?? ''); ?>" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">USDT (TRC20)</label>
                <input type="text" name="usdt_trc20" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['usdt_trc20'] ?? ''); ?>" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Ethereum Address</label>
                <input type="text" name="eth_address" class="w-full px-3 py-2 border border-gray-300 rounded-md" value="<?php echo e($settings['eth_address'] ?? ''); ?>" />
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Files</h2>
            
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Logo</label>
                <?php if($settings['logo'] ?? false): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/' . $settings['logo'])); ?>" alt="Logo" style="max-height: 100px;" />
                    </div>
                <?php endif; ?>
                <input type="file" name="logo" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-semibold">Favicon</label> 
                <?php if($settings['favicon'] ?? false): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset('storage/' . $settings['favicon'])); ?>" alt="Favicon" style="max-height: 50px;" />
                    </div>
                <?php endif; ?>
                <input type="file" name="favicon" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md" />
            </div>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Settings</button>
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">Cancel</a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>