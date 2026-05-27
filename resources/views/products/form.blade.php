@extends('layouts.app')
@section('title', $product->exists ? 'Edit Product' : 'Create Product')
@section('heading', $product->exists ? 'Edit Product' : 'New Product')

@section('content')

<div class="max-w-3xl">
    <div class="panel p-6">
        <form method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}"
              class="grid grid-cols-1 md:grid-cols-2 gap-5">
            @csrf
            @if($product->exists) @method('PUT') @endif

            <div>
                <label class="form-label" for="name">Name</label>
                <input id="name" class="form-input" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="sku">SKU</label>
                <input id="sku" class="form-input" name="sku" value="{{ old('sku', $product->sku) }}">
                @error('sku') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="category_id">Category</label>
                <select id="category_id" class="form-input" name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label" for="supplier_id">Supplier</label>
                <select id="supplier_id" class="form-input" name="supplier_id">
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label" for="purchase_price">Purchase Price</label>
                <input id="purchase_price" type="number" step="0.01" class="form-input" name="purchase_price"
                    value="{{ old('purchase_price', $product->purchase_price) }}">
            </div>

            <div>
                <label class="form-label" for="selling_price">Selling Price</label>
                <input id="selling_price" type="number" step="0.01" class="form-input" name="selling_price"
                    value="{{ old('selling_price', $product->selling_price) }}">
            </div>

            <div>
                <label class="form-label" for="current_stock">Stock</label>
                <input id="current_stock" type="number" class="form-input" name="current_stock"
                    value="{{ old('current_stock', $product->current_stock) }}">
            </div>

            <div>
                <label class="form-label" for="reorder_level">Reorder Level</label>
                <input id="reorder_level" type="number" class="form-input" name="reorder_level"
                    value="{{ old('reorder_level', $product->reorder_level ?? 10) }}">
            </div>

            <div class="md:col-span-2">
                <label class="form-label" for="description">Description</label>
                <textarea id="description" class="form-input" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="md:col-span-2 flex items-center gap-2.5">
                <input type="hidden" name="is_active" value="0">
                <input id="is_active" type="checkbox" name="is_active" value="1"
                    @checked(old('is_active', $product->is_active ?? true))
                    class="w-4 h-4 rounded border-slate-300 accent-[#047481]">
                <label for="is_active" class="text-sm font-medium text-slate-700 cursor-pointer">Active product</label>
            </div>

            <div class="md:col-span-2 flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Product
                </button>
                <a href="{{ route('products.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
