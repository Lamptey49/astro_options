

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Investment Plans</h1>

        <a href="<?php echo e(route('admin.plans.create')); ?>" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mb-4 inline-block">Create New Plan</a>

        <table class="w-full table-auto border-collapse border border-gray-700">
            <thead>
                <tr class="bg-gray-800">
                    <th class="border border-gray-600 px-4 py-2">Name</th>
                    <th class="border border-gray-600 px-4 py-2">Price (USD)</th>
                    <th class="border border-gray-600 px-4 py-2">Duration (Days)</th>
                    <th class="border border-gray-600 px-4 py-2">Features</th>
                    <th class="border border-gray-600 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="bg-gray-700">
                        <td class="border border-gray-600 px-4 py-2"><?php echo e($plan->name); ?></td>
                        <td class="border border-gray-600 px-4 py-2">$<?php echo e(number_format($plan->min_amount, 2)); ?></td>
                        <td class="border border-gray-600 px-4 py-2"><?php echo e($plan->duration_days); ?></td>
                        <td class="border border-gray-600 px-4 py-2">
                            <ul class="list-disc list-inside">
                                <?php $__currentLoopData = explode(',', $plan->features); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e(trim($feature)); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </td>
                        <td class="border border-gray-600 px-4 py-2">
                            <a href="<?php echo e(route('admin.plans.edit', $plan->id)); ?>" class="text-blue-500 hover:underline mr-2">Edit</a>
                            <form action="<?php echo e(route('admin.plans.destroy', $plan->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
        </table>
        
    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/plans/index.blade.php ENDPATH**/ ?>