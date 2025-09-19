@extends('user.layout')

@section('title', 'Quiz History - ' . $category->name)

@section('content')
<h1 class="text-3xl font-bold mb-6 text-blue-600">History: {{ $category->name }}</h1>

@if($quizzes->isEmpty())
    <p class="text-gray-600 text-lg">You haven't attempted any quizzes in this category yet.</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($quizzes as $result)
            @php
                $quiz = $result->quiz;

                // Total points possible for the quiz
                $totalPoints = $quiz->questions->sum('points');

                // Points earned by user for this quiz attempt
                $earnedPoints = $quiz->questions->sum(function($question) use ($result) {
                    $userAnswerIds = $result->answers
                        ->where('question_id', $question->id)
                        ->pluck('id')
                        ->sort()
                        ->values()
                        ->toArray();
                    $correctAnswerIds = $question->answers
                        ->where('is_correct', 1)
                        ->pluck('id')
                        ->sort()
                        ->values()
                        ->toArray();
                    return $userAnswerIds === $correctAnswerIds ? $question->points : 0;
                });

                // Progress bar percentage
                $progressPercent = $totalPoints ? round(($earnedPoints / $totalPoints) * 100) : 0;
            @endphp

            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $quiz->title }}</h2>
                    <p class="text-gray-500 mb-2">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

                    <p class="text-green-700 font-semibold mb-1">
                        Score: {{ $earnedPoints }} / {{ $totalPoints }}
                    </p>
                    <p class="text-gray-500 text-sm mb-2">
                        Attempted on: {{ $result->created_at->format('d M Y H:i') }}
                    </p>

                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded h-3 mt-2">
                        <div class="bg-blue-500 h-3 rounded" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ $progressPercent }}% Complete</p>
                </div>

                <a href="{{ route('user.quizzes.results.show', ['quiz' => $quiz, 'attempt' => $result->id]) }}"
                   class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-blue-600 transition-colors">
                    View Result
                </a>
            </div>
        @endforeach
    </div>
@endif

<div class="mt-6">
    <a href="{{ route('user.history.categories') }}" class="text-blue-600 hover:underline">← Back to Categories</a>
</div>
@endsection
