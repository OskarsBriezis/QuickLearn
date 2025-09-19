@extends('admin.layout')
@section('title','New Lesson')
@section('content')
  <h1 class="text-xl font-semibold mb-4">New Lesson</h1>
  <form method="POST" action="{{ route('admin.lessons.store') }}" class="space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Category</label>
      <select name="category_id" class="w-full border p-2">
        @foreach($categories as $c)
          <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
      </select>
      @error('category_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block mb-1">Title</label>
      <input name="title" class="w-full border p-2" value="{{ old('title') }}">
      @error('title') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block mb-1">Content</label>
      <textarea name="content" class="w-full border p-2" rows="8">{{ old('content') }}</textarea>
      @error('content') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
      <label class="block mb-1">Media URL (optional)</label>
      <input name="media_url" class="w-full border p-2" value="{{ old('media_url') }}">
      @error('media_url') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="published" value="1" checked>
      <span>Published</span>
    </label>
    <button class="px-3 py-2 bg-blue-600 text-white rounded">Create</button>
  </form>
@endsection
