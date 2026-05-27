@extends('layouts.app')
@section('title', 'Products')
@section('heading', 'Products')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <form class="flex flex-wrap gap-2" method="GET">
        <input class="form-input !mt-0 w-48" name="q" placeholder="Search name or SKU…" value="{{ request('q') }}">
        <select class="form-input !mt-0 w-44" name="category_id">
            <option value="">All categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((int) request('category_id') === $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            Filter
        </button>
    </form>
    <a href="{{ route('products.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
        Add Product
    </a>
</div>

{{-- Table --}}
<div class="panel overflow-x-auto">
    <table class="data-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Selling Price</th>
                <th>Status</th>
                <th class="text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($products as $product)
            <tr>
                <td class="font-medium text-slate-900">{{ $product->name }}</td>
                <td class="text-slate-500 font-mono text-xs">{{ $product->sku }}</td>
                <td>{{ $product->category->name }}</td>
                <td>
                    @if($product->current_stock <= ($product->reorder_level ?? 10))
                        <span class="badge badge-danger">{{ $product->current_stock }}</span>
                    @else
                        <span class="badge badge-success">{{ $product->current_stock }}</span>
                    @endif
                </td>
                <td class="font-medium">${{ number_format($product->selling_price, 2) }}</td>
                <td>
                    @if($product->is_active)
                        <span class="badge badge-success">Active</span>
                    @else
                        <span class="badge badge-neutral">Inactive</span>
                    @endif
                </td>
                <td class="text-right">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('products.edit', $product) }}"
                            class="text-sm font-medium text-[#047481] hover:text-[#036672] transition-colors">Edit</a>
                        <form method="POST" action="{{ route('products.destroy', $product) }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center py-10 text-slate-400">No products found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>

@endsection
