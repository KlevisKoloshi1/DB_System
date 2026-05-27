@extends('layouts.app')
@section('title', 'Suppliers')
@section('heading', 'Suppliers')

@section('content')

<div class="flex justify-end mb-5">
    <a href="{{ route('suppliers.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Add Supplier
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
        @forelse($suppliers as $supplier)
            <tr>
                <td class="font-medium text-slate-900">{{ $supplier->name }}</td>
                <td class="text-slate-500">{{ $supplier->email }}</td>
                <td class="text-slate-500">{{ $supplier->phone }}</td>
                <td class="text-slate-500">{{ $supplier->city }}</td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('suppliers.edit', $supplier) }}"
                            class="text-sm font-medium text-[#047481] hover:text-[#036672] transition-colors">Edit</a>
                        <form method="POST" action="{{ route('suppliers.destroy', $supplier) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center py-10 text-slate-400">No suppliers yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $suppliers->links() }}</div>

@endsection
