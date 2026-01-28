



<?php $__env->startSection('content'); ?>

<h1 class="text-2xl mb-6">Account Overview</h1>

<div class="cards">
    <div class="card">
        <h4>Balance</h4>
        <p class="text-xl">$<?php echo e(number_format(auth()->user()->balance,2)); ?></p>
    </div>

    <div class="card">
        <h4>Total Invested</h4>
        <p class="text-xl">$<?php echo e(number_format($totalFunds,2)); ?></p>
    </div>

    <div class="card">
        <h4>Active Plans</h4>
        <p class="text-xl"><?php echo e($plans); ?></p>
    </div>

    <div class="card">
        <h4>Profit</h4>
        <p class="text-xl">$<?php echo e(number_format($investmentCount,2)); ?></p>
    </div>
</div>

<div class="card mt-8">
    <h3 class="mb-4">Investment History</h3>
    <canvas id="investmentChart"></canvas>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const labels = <?php echo json_encode($chartLabels, 15, 512) ?>;
const data = <?php echo json_encode($chartData, 15, 512) ?>;

new Chart(document.getElementById('investmentChart'), {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Profit / Loss',
            data: data,
            tension: 0.4
        }]
    }
});
</script>

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('user.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/dashboard/index.blade.php ENDPATH**/ ?>