@extends('layouts.app')
@section('title', 'Supplier')
@section('heading', $supplier->exists ? 'Edit Supplier' : 'Create Supplier')
@section('content')
<form class="bg-white rounded shadow p-5 max-w-xl" method="POST" action="{{ $supplier->exists ? route('suppliers.update', $supplier) : route('suppliers.store') }}">
    @csrf
    @if($supplier->exists) @method('PUT') @endif
    <label class="block mb-3"><span>Name</span><input class="mt-1 w-full border rounded px-3 py-2" name="name" value="{{ old('name', $supplier->name) }}"></label>
    <label class="block mb-3"><span>Email</span><input class="mt-1 w-full border rounded px-3 py-2" name="email" value="{{ old('email', $supplier->email) }}"></label>
    <label class="block mb-3"><span>Phone</span><input class="mt-1 w-full border rounded px-3 py-2" name="phone" value="{{ old('phone', $supplier->phone) }}"></label>
    <label class="block mb-3"><span>City</span><input class="mt-1 w-full border rounded px-3 py-2" name="city" value="{{ old('city', $supplier->city) }}"></label>
    <label class="block mb-4"><span>Address</span><textarea class="mt-1 w-full border rounded px-3 py-2" name="address">{{ old('address', $supplier->address) }}</textarea></label>
    <button class="bg-slate-900 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
