@extends('user.layout')

@section('title', 'Quiz Summary - ' . $quiz->title)

@section('content')
<div class="max-w-xl mx-auto px-4 py-6 sm:px-6">
  <div class="bg-white shadow rounded-xl p-4 sm:p-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-blue-600">{{ $quiz->title }} - Summary</h1>

    @php
      $totalPoints = $quiz->questions->sum('points');
      $earnedPoints = $quiz->questions->sum(function ($question) use ($result) {
        $userAnswers = $result->answers->where('question_id', $question->id)->pluck('id')->toArray();
        $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();
        $isCorrect = collect($userAnswers)->sort()->values()->toArray() === collect($correctAnswers)->sort()->values()->toArray();
        return $isCorrect ? $question->points : 0;
      });
      $percentage = $totalPoints ? round(($earnedPoints / $totalPoints) * 100) : 0;
    @endphp

    {{-- Score --}}
    <p class="text-lg sm:text-xl mb-4">
      Your Score: <span class="font-semibold">{{ $earnedPoints }} / {{ $totalPoints }}</span>
    </p>

    {{-- Progress Bar --}}
    <div class="w-full bg-gray-200 rounded h-4 sm:h-6 mb-4">
      <div class="bg-green-500 h-4 sm:h-6 rounded" style="width: {{ $percentage }}%"></div>
    </div>
    <p class="text-sm sm:text-base text-gray-700 mb-6">{{ $percentage }}% Correct</p>

    {{-- Buttons --}}
    <div class="flex flex-col sm:flex-row gap-3">
      <a href="{{ route('user.quizzes.results.show', ['quiz' => $quiz->id, 'attempt' => $result->id]) }}"
         class="w-full sm:w-auto bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition">
        View Detailed Results
      </a>

      <a href="{{ route('user.quizzes.index') }}"
         class="w-full sm:w-auto bg-gray-500 text-white px-4 py-2 rounded text-center hover:bg-gray-600 transition">
        Back to Quizzes
      </a>
    </div>
  </div>
</div>
@endsection