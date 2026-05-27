<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-900">
<div class="min-h-screen flex">
    <aside class="w-64 bg-slate-900 text-white hidden md:block">
        <div class="px-6 py-5 text-xl font-bold border-b border-slate-700">Inventory ERP</div>
        <nav class="px-4 py-4 space-y-1">
            <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('products.index') }}">Products</a>
            <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('customers.index') }}">Customers</a>
            <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('suppliers.index') }}">Suppliers</a>
            @if(auth()->user()?->isAdmin())
                <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('categories.index') }}">Categories</a>
                <a class="block px-3 py-2 rounded hover:bg-slate-800" href="{{ route('reports.index') }}">Reports</a>
            @endif
        </nav>
    </aside>
    <main class="flex-1">
        <header class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center">
            <h1 class="font-semibold">@yield('heading', 'Inventory System')</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-slate-900 text-white px-4 py-2 rounded" type="submit">Logout</button>
            </form>
        </header>
        <section class="p-6">
            @if(session('success'))
                <div class="mb-4 bg-emerald-100 text-emerald-700 p-3 rounded">{{ session('success') }}</div>
            @endif
            @yield('content')
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@stack('scripts')
</body>
</html>
