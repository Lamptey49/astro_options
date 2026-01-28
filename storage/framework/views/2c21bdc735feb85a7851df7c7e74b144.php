

<?php $__env->startSection('content'); ?>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Create New Plan</h1>

        <form method="POST" action="<?php echo e(route('admin.plans.store')); ?>">
            <?php echo csrf_field(); ?>
        <div>
             <label for="name" class="block text-sm font-medium mb-1">Plan Name</label>
            <input name="name" class=" p-2 input border border-gray-300 rounded" placeholder="Plan Name" required>
        </div>
        <div>
             <label for="min_amount" class="block text-sm font-medium mb-1">Minimum (USD)</label>
        <input name="min_amount" class="p-2 input border border-gray-300 rounded" placeholder="Min Amount" required>
        </div>
        <div>
             <label for="max_amount" class="block text-sm font-medium mb-1">Maximum (USD)</label>
        <input name="max_amount" class=" p-2 input border border-gray-300 rounded" placeholder="Max Amount" required>
        </div>
        <div>
             <label for="duration_days" class="block text-sm font-medium mb-1">Duration (Days)</label>  
        <input name="duration_days" class=" p-2 input border border-gray-300 rounded" placeholder="Duration (Days)" required>
        </div>
        <div>
        <label for="roi_percent" class="block text-sm font-medium mb-1">ROI (%)</label>
        <input name="roi_percent" class=" p-2 input border border-gray-300 rounded" placeholder="ROI %" required>
        </div>
        <div>
        <label for="features" class="block text-sm font-medium mb-1">Features (Comma Separated)</label>
        <input type="text" name="features" class=" p-2 input border border-gray-300 rounded" placeholder="Features" required>
        </div>
        
         <button  class="bg-blue-600 text-white px-4 p-4 py-2 rounded hover:bg-blue-700">Create Plan</button>
       
        </form>

    </div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/plans/create.blade.php ENDPATH**/ ?>