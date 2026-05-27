@extends('layouts.app')
@section('title', 'Category')
@section('heading', $category->exists ? 'Edit Category' : 'New Category')

@section('content')

<div class="max-w-lg">
    <div class="panel p-6">
        <form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}"
              class="space-y-5">
            @csrf
            @if($category->exists) @method('PUT') @endif

            <div>
                <label class="form-label" for="name">Name</label>
                <input id="name" class="form-input" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="form-label" for="description">Description</label>
                <textarea id="description" class="form-input" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-2 border-t border-slate-100">
                <button type="submit" class="btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                    Save Category
                </button>
                <a href="{{ route('categories.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
