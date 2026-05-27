@extends('layouts.app')
@section('title', 'Categories')
@section('heading', 'Categories')
@section('content')
<a href="{{ route('categories.create') }}" class="bg-emerald-700 text-white px-3 py-2 rounded inline-block mb-3">Add Category</a>
<div class="bg-white rounded shadow">
    <table class="w-full text-sm">
        <thead><tr><th class="p-3 text-left">Name</th><th>Slug</th><th></th></tr></thead>
        <tbody>
        @foreach($categories as $category)
            <tr class="border-t"><td class="p-3">{{ $category->name }}</td><td>{{ $category->slug }}</td><td><a class="underline mr-2" href="{{ route('categories.edit', $category) }}">Edit</a><form class="inline" method="POST" action="{{ route('categories.destroy', $category) }}">@csrf @method('DELETE')<button class="text-red-700">Delete</button></form></td></tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $categories->links() }}</div>
@endsection
