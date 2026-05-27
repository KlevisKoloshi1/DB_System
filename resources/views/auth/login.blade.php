<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In — DB System</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @include('partials.vite-assets', ['entries' => ['resources/css/app.css', 'resources/js/app.js']])
</head>
<body class="h-full bg-[#f0f4f8] flex items-center justify-center p-6 antialiased">

<div class="w-full max-w-md">

    {{-- Logo / brand --}}
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('logo.png') }}" alt="DB System" class="h-14 w-14 object-contain mb-3">
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">DB System</h1>
        <p class="text-sm text-slate-500 mt-1">Inventory & Sales Management</p>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <h2 class="text-lg font-semibold text-slate-800 mb-6">Sign in to your account</h2>

        @if($errors->any())
            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div>{{ $errors->first() }}</div>
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-input" placeholder="you@example.com" autocomplete="email" required>
            </div>
            <div>
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password"
                    class="form-input" placeholder="••••••••" autocomplete="current-password" required>
            </div>
            <div class="flex items-center gap-2 pt-1">
                <input id="remember" type="checkbox" name="remember" value="1"
                    class="w-4 h-4 rounded border-slate-300 text-[#047481] accent-[#047481]">
                <label for="remember" class="text-sm text-slate-600 cursor-pointer">Remember me</label>
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2">
                Sign in
            </button>
        </form>
    </div>

    <p class="text-center text-sm text-slate-500 mt-5">
        No account?
        <a href="{{ route('register') }}" class="font-semibold text-[#047481] hover:text-[#036672] transition-colors">Create one</a>
    </p>
</div>

</body>
</html>
