@extends('user.layout')

@section('title','Lessons')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Lessons</h1>

{{-- Mobile-first card layout --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  @foreach($lessons as $lesson)
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col justify-between">
      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-1">{{ $lesson->title }}</h2>
        <p class="text-sm text-gray-500 mb-2">Category: {{ $lesson->category->name ?? '—' }}</p>
        <p class="text-xs text-gray-400">ID: {{ $lesson->id }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('user.lessons.show', $lesson) }}"
           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
          Read Lesson
        </a>
      </div>
    </div>
  @endforeach
</div>
@endsection