<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>  {{ settings('site_name') }} | Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="icon" href="{{ asset('storage/' . settings('favicon')) }}" type="image/x-icon"/>
      <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
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
<body class="bg-black min-h-screen text-gray-200">
    <header class="admin-topbar">
        <button onclick="toggleMenu()" class="menu-btn">☰</button>
        <h2>Dashboard</h2>
    </header>
<div class="flex">

    {{-- SIDEBAR --}}
    <aside id="sidebar"  class="sidebar  bg-[#06080d] border-r border-gray-800 p-5  md:block">
        <div class="mb-6">
            <p class="font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
        </div>

        <nav class="nav space-y-4 text-sm">
            <a href="/dashboard" class="flex items-center gap-3 hover:text-cyan-400 transition">
                <i class="fas fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="/deposit" class="flex items-center gap-3 hover:text-cyan-400 transition">
                <i class="fas fa-arrow-down w-5"></i>
                <span>Deposit</span>
            </a>
            <a href="/withdrawals" class="flex items-center gap-3 hover:text-cyan-400 transition">
                <i class="fas fa-arrow-up w-5"></i>
                <span>Withdraw</span>
            </a>
            <a href="/trade" class="flex items-center gap-3 text-cyan-400 font-semibold transition">
                <i class="fas fa-exchange-alt w-5"></i>
                <span>Trading</span>
            </a>
            <a href="/investments" class="flex items-center gap-3 text-cyan-400 font-semibold transition">
                <i class="fas fa-piggy-bank w-5"></i>
                <span>Investment Plan</span>
            </a>
            <a href="/transactions" class="flex items-center gap-3 hover:text-cyan-400 transition">
                <i class="fas fa-receipt w-5"></i>
                <span>Transactions</span>
            </a>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 hover:text-red-600 transition">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button> 
            </form>
        </nav>
    </aside>

    {{-- MAIN --}}
    <main class="content">
        @yield('content')
    </main>

</div>
</body>
</html>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-financial"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function toggleMenu() {
    document.getElementById('sidebar').classList.toggle('open');
}
</script>

@yield('scripts')
</body>
</html>
