@extends('layouts.app')
@section('title', 'Customer')
@section('heading', $customer->exists ? 'Edit Customer' : 'Create Customer')
@section('content')
<form class="bg-white rounded shadow p-5 max-w-xl" method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}">
    @csrf
    @if($customer->exists) @method('PUT') @endif
    <label class="block mb-3"><span>Name</span><input class="mt-1 w-full border rounded px-3 py-2" name="name" value="{{ old('name', $customer->name) }}"></label>
    <label class="block mb-3"><span>Email</span><input class="mt-1 w-full border rounded px-3 py-2" name="email" value="{{ old('email', $customer->email) }}"></label>
    <label class="block mb-3"><span>Phone</span><input class="mt-1 w-full border rounded px-3 py-2" name="phone" value="{{ old('phone', $customer->phone) }}"></label>
    <label class="block mb-3"><span>City</span><input class="mt-1 w-full border rounded px-3 py-2" name="city" value="{{ old('city', $customer->city) }}"></label>
    <label class="block mb-4"><span>Address</span><textarea class="mt-1 w-full border rounded px-3 py-2" name="address">{{ old('address', $customer->address) }}</textarea></label>
    <button class="bg-slate-900 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
