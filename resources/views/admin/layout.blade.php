<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>  {{ settings('site_name') }} | Admin Dashboard</title>
   @vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
 <link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
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
    <a href="{{ route('admin.dashboard') }}">
        <i class="fa-solid fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <a href="/admin/deposits">
        <i class="fa-brands fa-bitcoin"></i>
        <span>Deposits</span>
    </a>

    <a href="{{ route('admin.transactions.index') }}">
        <i class="fa-solid fa-chart-pie"></i>
        <span>Transactions</span>
    </a>

    <a href="{{ route('admin.users.index') }}">
        <i class="fa-solid fa-users"></i>
        <span>Users</span>
    </a>
    <a href="{{ route('admin.plans.index') }}">
        <i class="fa-solid fa-list"></i>
        <span>Plans</span>
    </a>
    <a href="{{ route('admin.pairs.index') }}">
        <i class="fa-solid fa-list"></i>
        <span>Trading Pairs</span>
    </a>
    <a href="{{ route('admin.settings.index') }}">
        <i class="fa-solid fa-cog"></i>
        <span>Settings</span>
    </a>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa-solid fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf   
    </form>
</nav>

</aside>

<!-- MAIN CONTENT -->
<main class="admin-content">
    @yield('content')
</main>

<script>
function toggleAdminMenu() {
    document.getElementById('adminSidebar').classList.toggle('open');
}
</script>

@yield('scripts')
</body>
</html>
