@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto p-6">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Quizzes</h1>

  @if($quizzes->isEmpty())
    <p class="text-gray-500">No quizzes found.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($quizzes as $quiz)
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
          <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2">📋 {{ $quiz->title }}</h2>
            <p class="text-sm text-gray-500 mb-1">ID: {{ $quiz->id }}</p>
            <p class="text-sm text-gray-500">Lesson: {{ $quiz->lesson->title }}</p>
          </div>

          <div class="mt-4 flex gap-2">
            <a href="{{ route('admin.quizzes.edit', $quiz) }}"
               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
              Edit
            </a>
            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST"
                  onsubmit="return confirm('Delete this quiz?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                Delete
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection