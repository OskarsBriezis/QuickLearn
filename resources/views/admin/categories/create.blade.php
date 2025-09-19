@extends('admin.layout')
@section('title','New Category')
@section('content')
  <h1 class="text-xl font-semibold mb-4">New Category</h1>
  <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Name</label>
      <input name="name" class="w-full border p-2" value="{{ old('name') }}">
      @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block mb-1">Description</label>
      <textarea name="description" class="w-full border p-2" rows="4">{{ old('description') }}</textarea>
    </div>
    <button class="px-3 py-2 bg-blue-600 text-white rounded">Create</button>
  </form>
@endsection
