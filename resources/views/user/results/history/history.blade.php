@extends('user.layout')

@section('title', 'Quiz Summary - ' . $quiz->title)

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-8 text-center">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">{{ $quiz->title }}</h1>

    <p class="text-gray-600 mb-4">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

    <div class="bg-blue-100 rounded-full p-6 mb-6">
        <p class="text-5xl font-bold text-blue-600">{{ $result->score }} / {{ $result->total }}</p>
        <p class="text-gray-700 mt-2">Your Score</p>
    </div>

    <div class="flex justify-center gap-4">
        <a href="{{ route('user.quizzes.results.show', ['quiz' => $quiz->id, 'attempt' => $result->id]) }}"
           class="bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition-colors">
            View Detailed Results
        </a>

        <a href="{{ route('user.home') }}"
           class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-medium hover:bg-gray-300 transition-colors">
            Back to Quizzes
        </a>
    </div>
</div>
@endsection
