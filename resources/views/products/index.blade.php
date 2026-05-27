@extends('layouts.app')
@section('title', 'Products')
@section('heading', 'Products')

@section('content')
    <div class="mb-4 flex flex-wrap gap-2">
        <form class="flex gap-2" method="GET">
            <input class="border rounded px-3 py-2" name="q" placeholder="Search name or SKU" value="{{ request('q') }}">
            <select class="border rounded px-3 py-2" name="category_id">
                <option value="">All categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected((int) request('category_id') === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
            <button class="bg-slate-800 text-white px-3 rounded">Filter</button>
        </form>
        <a href="{{ route('products.create') }}" class="bg-emerald-700 text-white px-3 py-2 rounded">Add Product</a>
    </div>
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50"><tr><th class="p-3 text-left">Product</th><th>SKU</th><th>Category</th><th>Stock</th><th>Price</th><th></th></tr></thead>
            <tbody>
            @foreach($products as $product)
                <tr class="border-t">
                    <td class="p-3">{{ $product->name }}</td><td>{{ $product->sku }}</td><td>{{ $product->category->name }}</td><td>{{ $product->current_stock }}</td><td>${{ number_format($product->selling_price, 2) }}</td>
                    <td class="p-3">
                        <a class="underline mr-2" href="{{ route('products.edit', $product) }}">Edit</a>
                        <form class="inline" method="POST" action="{{ route('products.destroy', $product) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
@endsection
