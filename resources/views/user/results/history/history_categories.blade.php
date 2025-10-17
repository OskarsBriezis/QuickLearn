@extends('user.layout')

@section('title', 'Quiz History Categories')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 sm:px-6">
  <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-blue-600">Your Quiz History</h1>

  @if($categories->isEmpty())
    <p class="text-gray-600 text-base sm:text-lg">You haven't attempted any quizzes yet.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($categories as $category)
        @php
          $attempts = $category->lessons()->with('quizzes.results')
                              ->get()
                              ->flatMap(fn($lesson) => $lesson->quizzes)
                              ->flatMap(fn($quiz) => $quiz->results->where('user_id', auth()->id()))
                              ->count();
        @endphp

        <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
          <div>
            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-2">{{ $category->name }}</h2>
            <p class="text-sm sm:text-base text-gray-500 mb-2">Quizzes attempted: {{ $attempts }}</p>
          </div>

          <a href="{{ route('user.history.quizzes', $category->id) }}"
             class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-blue-600 transition">
            View Quizzes
          </a>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection