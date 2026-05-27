<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory') — DB System</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @include('partials.vite-assets', ['entries' => ['resources/css/app.css', 'resources/js/app.js']])
</head>
<body class="h-full bg-[#f0f4f8] text-slate-900 antialiased">

<div class="min-h-screen flex">

    {{-- ── Sidebar ── --}}
    <aside id="sidebar" class="w-64 bg-[#0b1f2e] text-white flex flex-col shrink-0 hidden md:flex">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/10">
            <img src="{{ asset('logo.png') }}" alt="DB System logo" class="h-8 w-8 object-contain rounded">
            <span class="text-base font-bold tracking-tight text-white">DB System</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <p class="px-3 pt-2 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Main</p>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Dashboard
                </span>
            </a>
            <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    Products
                </span>
            </a>
            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Customers
                </span>
            </a>
            <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                <span class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    Suppliers
                </span>
            </a>
            @if(auth()->user()?->isAdmin())
                <p class="px-3 pt-4 pb-1 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Admin</p>
                <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                    <span class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7"/></svg>
                        Categories
                    </span>
                </a>
                <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                    <span class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
                        Reports
                    </span>
                </a>
            @endif
        </nav>

        {{-- User footer --}}
        <div class="px-4 py-4 border-t border-white/10">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-[#047481] flex items-center justify-center text-xs font-bold text-white shrink-0">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ auth()->user()?->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ auth()->user()?->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── Main content ── --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top header --}}
        <header class="bg-white border-b border-slate-200 px-6 py-3.5 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                {{-- Mobile menu toggle --}}
                <button id="sidebar-toggle" class="md:hidden p-1.5 rounded-md text-slate-500 hover:bg-slate-100" aria-label="Toggle menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-base font-semibold text-slate-800">@yield('heading', 'Inventory System')</h1>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors px-3 py-1.5 rounded-md hover:bg-slate-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </header>

        {{-- Page content --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @if(session('success'))
                <div class="mb-5 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 shrink-0 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-5 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4 shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>

{{-- Mobile sidebar overlay --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
<div id="sidebar-mobile" class="fixed inset-y-0 left-0 w-64 bg-[#0b1f2e] text-white z-50 flex flex-col transform -translate-x-full transition-transform duration-200 md:hidden">
    <div class="flex items-center justify-between px-5 py-5 border-b border-white/10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="DB System logo" class="h-8 w-8 object-contain rounded">
            <span class="text-base font-bold tracking-tight text-white">DB System</span>
        </div>
        <button id="sidebar-close" class="text-slate-400 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
    </div>
    <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
        <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
        <a class="nav-link" href="{{ route('suppliers.index') }}">Suppliers</a>
        @if(auth()->user()?->isAdmin())
            <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
            <a class="nav-link" href="{{ route('reports.index') }}">Reports</a>
        @endif
    </nav>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // ── Mobile sidebar ──
    const toggle = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');
    const mobileSidebar = document.getElementById('sidebar-mobile');
    const closeBtn = document.getElementById('sidebar-close');
    function openSidebar() {
        mobileSidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }
    function closeSidebar() {
        mobileSidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }
    toggle?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
@stack('scripts')
</body>
</html>
