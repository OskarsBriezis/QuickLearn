@extends('admin.layout')
@section('title','Edit Category')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Category</h1>

<div class="bg-white shadow-md rounded-lg p-6 max-w-xl mx-auto">
  <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
    @csrf @method('PUT')

    {{-- Name --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
      <input id="name" name="name" type="text"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
             value="{{ old('name', $category->name) }}">
      @error('name')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
      @enderror
    </div>

    {{-- Description --}}
    <div>
      <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
      <textarea id="description" name="description" rows="4"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
    </div>

    {{-- Submit --}}
    <div class="text-right">
      <button type="submit"
              class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
        Save Changes
      </button>
    </div>
  </form>
</div>
@endsection