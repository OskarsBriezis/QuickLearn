@extends('admin.layout')

@section('title','Categories')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Categories</h1>

{{-- Search Bar --}}
<form method="GET" action="{{ route('admin.categories.index') }}" class="mb-6">
  <div class="flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Search categories..."
           class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
    <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
      Search
    </button>
  </div>
</form>

{{-- Category Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
  @forelse($categories as $category)
    <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-between">
      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-2">📁 {{ $category->name }}</h2>
        <p class="text-sm text-gray-500">ID: {{ $category->id }}</p>
      </div>
      <div class="mt-4 flex gap-2">
        <a href="{{ route('admin.categories.edit', $category) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
          Edit
        </a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
          @csrf @method('DELETE')
          <button type="submit"
                  class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
            Delete
          </button>
        </form>
      </div>
    </div>
  @empty
    <p class="text-gray-500">No categories found.</p>
  @endforelse
</div>

{{-- Pagination --}}
<div class="mt-8">
  {{ $categories->withQueryString()->links() }}
</div>
@endsection