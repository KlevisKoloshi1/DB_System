@extends('layouts.app')
@section('title', 'Suppliers')
@section('heading', 'Suppliers')
@section('content')
<a href="{{ route('suppliers.create') }}" class="bg-emerald-700 text-white px-3 py-2 rounded inline-block mb-3">Add Supplier</a>
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm"><thead><tr><th class="p-3 text-left">Name</th><th>Email</th><th>City</th><th></th></tr></thead><tbody>
@foreach($suppliers as $supplier)
<tr class="border-t"><td class="p-3">{{ $supplier->name }}</td><td>{{ $supplier->email }}</td><td>{{ $supplier->city }}</td><td><a class="underline mr-2" href="{{ route('suppliers.edit', $supplier) }}">Edit</a><form class="inline" method="POST" action="{{ route('suppliers.destroy', $supplier) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form></td></tr>
@endforeach
</tbody></table></div><div class="mt-4">{{ $suppliers->links() }}</div>
@endsection
