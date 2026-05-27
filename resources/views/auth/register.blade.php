<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — DB System</title>
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
        <h2 class="text-lg font-semibold text-slate-800 mb-6">Create your account</h2>

        <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label" for="name">Full name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                    class="form-input" placeholder="Jane Smith" autocomplete="name" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="email">Email address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="form-input" placeholder="you@example.com" autocomplete="email" required>
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="password">Password</label>
                <input id="password" type="password" name="password"
                    class="form-input" placeholder="••••••••" autocomplete="new-password" required>
                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="password_confirmation">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="form-input" placeholder="••••••••" autocomplete="new-password" required>
            </div>
            <button type="submit" class="btn-primary w-full justify-center py-2.5 mt-2">
                Create account
            </button>
        </form>
    </div>

    <p class="text-center text-sm text-slate-500 mt-5">
        Already have an account?
        <a href="{{ route('login') }}" class="font-semibold text-[#047481] hover:text-[#036672] transition-colors">Sign in</a>
    </p>
</div>

</body>
</html>
