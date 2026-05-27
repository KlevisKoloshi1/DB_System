@extends('layouts.app')
@section('title', 'Customer')
@section('heading', $customer->exists ? 'Edit Customer' : 'New Customer')

@section('content')

<div class="max-w-lg">
    <div class="panel p-6">
        <form method="POST" action="{{ $customer->exists ? route('customers.update', $customer) : route('customers.store') }}"
              class="space-y-5">
            @csrf
            @if($customer->exists) @method('PUT') @endif

            <div>
                <label class="form-label" for="name">Full name</label>
                <input id="name" class="form-input" name="name" value="{{ old('name', $customer->name) }}" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="email">Email</label>
                <input id="email" type="email" class="form-input" name="email" value="{{ old('email', $customer->email) }}">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="phone">Phone</label>
                <input id="phone" type="tel" class="form-input" name="phone" value="{{ old('phone', $customer->phone) }}">
            </div>

            <div>
                <label class="form-label" for="city">City</label>
                <input id="city" class="form-input" name="city" value="{{ old('city', $customer->city) }}">
            </div>

            <div>
                <label class="form-label" for="address">Address</label>
                <textarea id="address" class="form-input" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Customer
                </button>
                <a href="{{ route('customers.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
