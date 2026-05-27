@extends('layouts.app')
@section('title', 'Customers')
@section('heading', 'Customers')

@section('content')

<div class="flex justify-end mb-5">
    <a href="{{ route('customers.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Add Customer
    </a>
</div>

<div class="panel overflow-x-auto">
    <table class="data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($customers as $customer)
            <tr>
                <td class="font-medium text-slate-900">{{ $customer->name }}</td>
                <td class="text-slate-500">{{ $customer->email }}</td>
                <td class="text-slate-500">{{ $customer->phone }}</td>
                <td class="text-slate-500">{{ $customer->city }}</td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('customers.edit', $customer) }}"
                            class="text-sm font-medium text-[#047481] hover:text-[#036672] transition-colors">Edit</a>
                        <form method="POST" action="{{ route('customers.destroy', $customer) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-10 text-slate-400">No customers yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $customers->links() }}</div>

@endsection
