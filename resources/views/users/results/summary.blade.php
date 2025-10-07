@extends('user.layout')

@section('title', 'Quiz Summary - ' . $quiz->title)

@section('content')
<div class="p-6 bg-white shadow rounded max-w-xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - Summary</h1>

    @php
        // Total points possible
        $totalPoints = $quiz->questions->sum('points');

        // Points earned in this attempt
        $earnedPoints = $quiz->questions->sum(function ($question) use ($result) {
            $userAnswers = $result->answers->where('question_id', $question->id)->pluck('answer_id')->toArray();
            $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();

            $isCorrect = collect($userAnswers)->sort()->values()->toArray() === collect($correctAnswers)->sort()->values()->toArray();

            return $isCorrect ? $question->points : 0;
        });

        // Calculate percentage
        $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
    @endphp

    {{-- Score --}}
    <p class="text-xl mb-4">
        Your Score: <span class="font-semibold">{{ $earnedPoints }} / {{ $totalPoints }}</span>
    </p>

    {{-- Progress Bar --}}
<div class="w-full bg-gray-200 rounded h-6 mb-6">
    <div class="bg-green-500 h-6 rounded" style="width: {{ $percentage }}%"></div>
</div>
<p class="text-gray-700 mb-6">{{ $percentage }}% Correct</p>

    {{-- Buttons --}}
    <div class="flex gap-2">
        <a href="{{ route('user.quizzes.results.show', ['quiz' => $quiz->id, 'attempt' => $result->id]) }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            View Detailed Results
        </a>

        <a href="{{ route('user.quizzes.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Quizzes
        </a>
    </div>
</div>
@endsection
