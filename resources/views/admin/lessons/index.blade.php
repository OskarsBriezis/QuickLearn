@extends('admin.layout')

@section('title','Lessons')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Lessons</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
  @forelse($lessons as $lesson)
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-2">📘 {{ $lesson->title }}</h2>
        <p class="text-sm text-gray-500 mb-1">ID: {{ $lesson->id }}</p>
        <p class="text-sm text-gray-500">Category: {{ $lesson->category->name ?? '—' }}</p>
      </div>
      <div class="mt-4 flex gap-2">
        <a href="{{ route('admin.lessons.edit', $lesson) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
          Edit
        </a>
        <form action="{{ route('admin.lessons.destroy', $lesson) }}" method="POST" onsubmit="return confirm('Delete this lesson?')">
          @csrf @method('DELETE')
          <button type="submit"
                  class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
            Delete
          </button>
        </form>
      </div>
    </div>
  @empty
    <p class="text-gray-500">No lessons found.</p>
  @endforelse
</div>
@endsection