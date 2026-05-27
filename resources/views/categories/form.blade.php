@extends('layouts.app')
@section('title', 'Category')
@section('heading', $category->exists ? 'Edit Category' : 'Create Category')
@section('content')
<form class="bg-white rounded shadow p-5 max-w-xl" method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}">
    @csrf
    @if($category->exists) @method('PUT') @endif
    <label class="block mb-3"><span>Name</span><input class="mt-1 w-full border rounded px-3 py-2" name="name" value="{{ old('name', $category->name) }}">@error('name')<small class="text-red-600">{{ $message }}</small>@enderror</label>
    <label class="block mb-4"><span>Description</span><textarea class="mt-1 w-full border rounded px-3 py-2" name="description">{{ old('description', $category->description) }}</textarea></label>
    <button class="bg-slate-900 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
