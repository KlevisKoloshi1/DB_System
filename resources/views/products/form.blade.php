@extends('layouts.app')
@section('title', $product->exists ? 'Edit Product' : 'Create Product')
@section('heading', $product->exists ? 'Edit Product' : 'Create Product')

@section('content')
    <form class="bg-white rounded-lg shadow p-5 grid gap-4 md:grid-cols-2" method="POST" action="{{ $product->exists ? route('products.update', $product) : route('products.store') }}">
        @csrf
        @if($product->exists) @method('PUT') @endif
        <label><span>Name</span><input class="mt-1 w-full border rounded px-3 py-2" name="name" value="{{ old('name', $product->name) }}">@error('name')<small class="text-red-600">{{ $message }}</small>@enderror</label>
        <label><span>SKU</span><input class="mt-1 w-full border rounded px-3 py-2" name="sku" value="{{ old('sku', $product->sku) }}">@error('sku')<small class="text-red-600">{{ $message }}</small>@enderror</label>
        <label><span>Category</span><select class="mt-1 w-full border rounded px-3 py-2" name="category_id">@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
        <label><span>Supplier</span><select class="mt-1 w-full border rounded px-3 py-2" name="supplier_id">@foreach($suppliers as $supplier)<option value="{{ $supplier->id }}" @selected(old('supplier_id', $product->supplier_id) == $supplier->id)>{{ $supplier->name }}</option>@endforeach</select></label>
        <label><span>Purchase Price</span><input type="number" step="0.01" class="mt-1 w-full border rounded px-3 py-2" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"></label>
        <label><span>Selling Price</span><input type="number" step="0.01" class="mt-1 w-full border rounded px-3 py-2" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"></label>
        <label><span>Stock</span><input type="number" class="mt-1 w-full border rounded px-3 py-2" name="current_stock" value="{{ old('current_stock', $product->current_stock) }}"></label>
        <label><span>Reorder Level</span><input type="number" class="mt-1 w-full border rounded px-3 py-2" name="reorder_level" value="{{ old('reorder_level', $product->reorder_level ?? 10) }}"></label>
        <label class="md:col-span-2"><span>Description</span><textarea class="mt-1 w-full border rounded px-3 py-2" name="description">{{ old('description', $product->description) }}</textarea></label>
        <label class="flex items-center gap-2 md:col-span-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Active</label>
        <button class="bg-slate-900 text-white px-4 py-2 rounded md:col-span-2 w-max" type="submit">Save Product</button>
    </form>
@endsection
