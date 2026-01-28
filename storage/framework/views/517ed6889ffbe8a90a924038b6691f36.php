<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>  <?php echo e(settings('site_name')); ?> | Admin Dashboard</title>
   <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 <link rel="icon" href="<?php echo e(asset('storage/' . settings('favicon'))); ?>" type="image/x-icon"/>
</head>

<body class="admin-bg">

<!-- MOBILE TOP BAR -->
<header class="admin-topbar">
    <button onclick="toggleAdminMenu()" class="menu-btn">☰</button>
    <h2>Admin Panel</h2>
</header>

<!-- SIDEBAR -->
<aside id="adminSidebar" class="admin-sidebar">
    <h3 class="logo">Admin</h3>

  <nav class="admin-nav">
    <a href="<?php echo e(route('admin.dashboard')); ?>">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <a href="/admin/deposits">
        <i class="fa-brands fa-bitcoin"></i>
        <span>Deposits</span>
    </a>

    <a href="<?php echo e(route('admin.transactions.index')); ?>">
        <i class="fa-solid fa-chart-pie"></i>
        <span>Transactions</span>
    </a>

    <a href="<?php echo e(route('admin.users.index')); ?>">
        <i class="fa-solid fa-users"></i>
        <span>Users</span>
    </a>
    <a href="<?php echo e(route('admin.plans.index')); ?>">
        <i class="fa-solid fa-list"></i>
        <span>Plans</span>
    </a>
    <a href="<?php echo e(route('admin.pairs.index')); ?>">
        <i class="fa-solid fa-list"></i>
        <span>Trading Pairs</span>
    </a>
    <a href="<?php echo e(route('admin.settings.index')); ?>">
        <i class="fa-solid fa-cog"></i>
        <span>Settings</span>
    </a>
    <a href="<?php echo e(route('logout')); ?>"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>   
    </form>
</nav>

</aside>

<!-- MAIN CONTENT -->
<main class="admin-content">
    <?php echo $__env->yieldContent('content'); ?>
</main>

<script>
function toggleAdminMenu() {
    document.getElementById('adminSidebar').classList.toggle('open');
}
</script>

<?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\Phinehas KwakuFix\Herd\crypto-invest\resources\views/admin/layout.blade.php ENDPATH**/ ?>