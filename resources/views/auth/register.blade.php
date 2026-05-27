<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center p-6">
<form method="POST" action="{{ route('register.store') }}" class="w-full max-w-md bg-white p-6 rounded-lg shadow">
    @csrf
    <h1 class="text-2xl font-bold mb-6">Create Account</h1>
    <label class="block mb-3"><span>Name</span><input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full border rounded px-3 py-2">@error('name') <small class="text-red-600">{{ $message }}</small> @enderror</label>
    <label class="block mb-3"><span>Email</span><input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full border rounded px-3 py-2">@error('email') <small class="text-red-600">{{ $message }}</small> @enderror</label>
    <label class="block mb-3"><span>Password</span><input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2">@error('password') <small class="text-red-600">{{ $message }}</small> @enderror</label>
    <label class="block mb-4"><span>Confirm Password</span><input type="password" name="password_confirmation" class="mt-1 w-full border rounded px-3 py-2"></label>
    <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded">Register</button>
    <p class="mt-4 text-sm">Already registered? <a class="underline" href="{{ route('login') }}">Login</a></p>
</form>
</body>
</html>
