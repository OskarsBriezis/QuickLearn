@extends('user.layout')

@section('title', 'Quiz Summary - ' . $quiz->title)

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6 sm:px-6">
  <div class="bg-white rounded-xl shadow-lg p-6 sm:p-8 text-center">
    <h1 class="text-2xl sm:text-3xl font-bold text-blue-600 mb-4 sm:mb-6">{{ $quiz->title }}</h1>

    <p class="text-gray-600 text-sm sm:text-base mb-4">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

    <div class="bg-blue-100 rounded-full p-4 sm:p-6 mb-6">
      <p class="text-4xl sm:text-5xl font-bold text-blue-600">{{ $result->score }} / {{ $result->total }}</p>
      <p class="text-gray-700 mt-2 text-sm sm:text-base">Your Score</p>
    </div>

    <div class="flex flex-col sm:flex-row justify-center gap-4">
      <a href="{{ route('user.quizzes.results.show', ['quiz' => $quiz->id, 'attempt' => $result->id]) }}"
         class="w-full sm:w-auto bg-blue-500 text-white px-6 py-3 rounded-lg font-medium text-center hover:bg-blue-600 transition">
        View Detailed Results
      </a>

      <a href="{{ route('user.home') }}"
         class="w-full sm:w-auto bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium text-center hover:bg-gray-300 transition">
        Back to Quizzes
      </a>
    </div>
  </div>
</div>
@endsection