<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo e(settings('site_name')); ?>

    </title>
   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" href="<?php echo e(asset('storage/' . settings('favicon'))); ?>" type="image/x-icon"/>
<!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '414b3128b96fd6d5fb93ed56fa2b5ee11c86ab8c';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript> Powered by <a href=“https://www.smartsupp.com” target=“_blank”>Smartsupp</a></noscript>

</head>
<body class="bg-[#0b0f19] text-gray-200 font-sans">

<!-- NAVBAR -->
<nav class="fixed top-0 w-full z-50 bg-black/60 backdrop-blur border-b border-white/10">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-white tracking-wide">
            <?php
                $logo = settings('logo');
            ?>
            <?php if($logo && file_exists(storage_path('app/public/' . $logo))): ?>
                <img src="<?php echo e(asset('storage/' . $logo)); ?>" alt="Logo" style="max-height: 40px;">
            <?php else: ?>
                <span><?php echo e(settings('site_name')); ?></span>
            <?php endif; ?>
        </h1>
        <div class="space-x-6 text-sm">
             <?php if(auth()->guard()->guest()): ?>
            <!-- User NOT logged in -->
                <a href="<?php echo e(route('login')); ?>" class="px-5 py-2 rounded-lg bg-transparent border border-white text-white hover:bg-white hover:text-black transition">
                    Login
                </a>
                <a href="<?php echo e(route('register')); ?>"  class="px-5 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Register
                </a>
            <?php endif; ?>
            <?php if(auth()->guard()->check()): ?>
                <!-- User logged in -->
                <a href="<?php echo e(route('user.dashboard')); ?>"   class="text-white hover:text-indigo-400">
                    Dashboard
                </a>
            <?php endif; ?>
          

        </div>
    </div>
</nav>
<?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- PAGE CONTENT -->
<main class="pt-28 px-6 max-w-7xl mx-auto">
    <?php echo $__env->yieldContent('content'); ?>
</main>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.stat-card');

    const animateCounter = (counter) => {
        const target = +counter.dataset.target;
        const display = counter.querySelector('.counter');
        let count = 0;
        const speed = target / 120;

        const update = () => {
            count += speed;
            if (count < target) {
                display.innerText = Math.floor(count).toLocaleString();
                requestAnimationFrame(update);
            } else {
                display.innerText = target.toLocaleString();
            }
        };
        update();
    };

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.6 });

    counters.forEach(counter => observer.observe(counter));
});
</script>
<script>
document.querySelectorAll('.counter').forEach(counter => {
    const update = () => {
        const target = +counter.dataset.target;
        const current = +counter.innerText;
        const increment = target / 100;

        if (current < target) {
            counter.innerText = Math.ceil(current + increment);
            setTimeout(update, 20);
        } else {
            counter.innerText = target;
        }
    };
    update();
});
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('stocks-chart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
            label: 'Market Index',
            data: [120, 190, 300, 250, 220, 310, 400],
            tension: 0.4,
        }]
    },
});


</body>
</html>
<?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/layouts/app.blade.php ENDPATH**/ ?>