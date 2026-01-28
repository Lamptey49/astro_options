

<?php $__env->startSection('content'); ?>

<h1 class="text-2xl mb-6">Admin Overview</h1>

<div class="admin-cards">
    <div class="admin-card">
        <h4>Total Users</h4>
        <p class="text-xl"><?php echo e($users); ?></p>
    </div>

    <div class="admin-card">
        <h4>Total Deposits</h4>
        <p class="text-xl">$<?php echo e(number_format($totalDeposits ?? 0, 2)); ?></p>
    </div>

    <div class="admin-card">
        <h4>Pending Crypto</h4>
        <p class="text-xl"><?php echo e($pendingCrypto); ?></p>
    </div>

    <div class="admin-card">
        <h4>Total Investments</h4>
        <p class="text-xl">$<?php echo e(number_format($investments,2)); ?></p>
    </div>
</div>


<div class="grid grid-cols-2 gap-6">
    <div style="height: 300px; width: 100%;">
        <h2>Total Trades</h2>
        <canvas id="tradeTypeChart"></canvas>
    </div>
    <div style="height: 300px; width: 100%;">
        <h2>Total Withdrawals</h2>
        <canvas id="withdrawalChart"></canvas>
    </div>
</div>
<div class="grid grid-cols-2 gap-6">
    <div style="height: 300px; width: 100%;">
        <h2>Approved Deposits</h2>
        <canvas id="depositChart"></canvas>
    </div>
    <div style="height: 300px; width: 100%;">
        <h2>Profit Trend</h2>
        <canvas id="tradeStatusChart"></canvas>
    </div>
</div>

</div>




<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('depositChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels, 15, 512) ?>,
        datasets: [{
            label: 'Approved Deposits',
            data: <?php echo json_encode($values, 15, 512) ?>,
            borderWidth: 2,
            backgroundColor: 'rgba(48, 148, 214, 0.2)',
            borderColor: 'rgb(240, 10, 10)',
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // REQUIRED
        animation: false,
        scales: {
            x: { display: true },
            y: { display: true }
        },
        plugins: {
        legend: {
            position: 'top',
        },
    }
    }
});

</script>
<script>
    const ctx1 = document.getElementById('withdrawalChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($Datalabels, 15, 512) ?>,
        datasets: [{
            data: <?php echo json_encode($data, 15, 512) ?>,
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // REQUIRED
        animation: false,
        scales: {
            x: { display: true },
            y: { display: true }
        }
    }
});
</script>
<script>
    const ctx2 = document.getElementById('tradeTypeChart').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($tradeTypeLabels, 15, 512) ?>,
        datasets: [{ 
            data: <?php echo json_encode($tradeTypeData, 15, 512) ?>,
            borderWidth: 2,
            tension: 0.3
         }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // REQUIRED
        animation: false,
        scales: {
            x: { display: true },
            y: { display: true }
        }
    }
});
const ctx3 = document.getElementById('tradeStatusChart').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($statusLabels, 15, 512) ?>,
        datasets: [{ data: <?php echo json_encode($statusData, 15, 512) ?> ,
            borderWidth: 2,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // REQUIRED
        animation: false,
        scales: {
            x: { display: true },
            y: { display: true }
        }
    }
});
const ctx4 = document.getElementById('profitChart').getContext('2d');
new Chart(ctx4, {
    type: 'doughnut',
    data: {
        labels: [...Array(<?php echo json_encode($profitTrend, 15, 512) ?>.length).keys()],
        datasets: [{
            label: 'Profit Trend',
            data: <?php echo json_encode($profitTrend, 15, 512) ?>,
            borderWidth: 2,
            tension: 0.3
        }]
    },  
    options: {
    responsive: true,
    maintainAspectRatio: false, // REQUIRED
        animation: false,
        scales: {
            x: { display: true },
            y: { display: true }
        },
    plugins: {
      legend: {
        position: 'top',
      },
    }
  },
});
</script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>