@extends('layouts.app')
@section('title', 'Customers')
@section('heading', 'Customers')
@section('content')
<a href="{{ route('customers.create') }}" class="bg-emerald-700 text-white px-3 py-2 rounded inline-block mb-3">Add Customer</a>
<div class="bg-white rounded shadow overflow-x-auto">
<table class="w-full text-sm"><thead><tr><th class="p-3 text-left">Name</th><th>Email</th><th>City</th><th></th></tr></thead><tbody>
@foreach($customers as $customer)
<tr class="border-t"><td class="p-3">{{ $customer->name }}</td><td>{{ $customer->email }}</td><td>{{ $customer->city }}</td><td><a class="underline mr-2" href="{{ route('customers.edit', $customer) }}">Edit</a><form class="inline" method="POST" action="{{ route('customers.destroy', $customer) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form></td></tr>
@endforeach
</tbody></table></div><div class="mt-4">{{ $customers->links() }}</div>
@endsection
