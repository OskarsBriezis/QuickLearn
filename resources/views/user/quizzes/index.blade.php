@extends('user.layout')

@section('title','Quizzes')

@section('content')
<div class="max-w-6xl mx-auto p-4 sm:p-6">
  <h1 class="text-2xl font-bold mb-6">Quizzes</h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($quizzes as $quiz)
      @php
        $completed = $quiz->results->where('user_id', auth()->id())->count() > 0;
      @endphp
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 flex flex-col justify-between">
        <div>
          <h2 class="text-lg font-bold text-gray-800 mb-1">{{ $quiz->title }}</h2>
          <p class="text-sm text-gray-500 mb-1">Lesson: {{ $quiz->lesson->title }}</p>
          <p class="text-sm text-gray-500">Status:
            <span class="{{ $completed ? 'text-green-600 font-semibold' : 'text-red-500' }}">
              {{ $completed ? 'Completed' : 'Not Attempted' }}
            </span>
          </p>
        </div>
        <div class="mt-4">
          <form action="{{ route('user.quizzes.show', $quiz) }}" method="GET">
            <button type="submit"
                    class="w-full bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
              {{ $completed ? 'Review' : 'Take Quiz' }}
            </button>
          </form>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection