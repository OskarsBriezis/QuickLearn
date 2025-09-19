@extends('admin.layout')
@section('title','Edit Category')
@section('content')
  <h1 class="text-xl font-semibold mb-4">Edit Category</h1>
  <form method="POST" action="{{ route('admin.categories.update',$category) }}" class="space-y-4">
    @csrf @method('PUT')
    <div>
      <label class="block mb-1">Name</label>
      <input name="name" class="w-full border p-2" value="{{ old('name',$category->name) }}">
      @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block mb-1">Description</label>
      <textarea name="description" class="w-full border p-2" rows="4">{{ old('description',$category->description) }}</textarea>
    </div>
    <button class="px-3 py-2 bg-blue-600 text-white rounded">Save</button>
  </form>
@endsection
