@extends('user.layout')

@section('title', 'Quizzes')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-blue-600">All Quizzes</h1>

@if($quizzes->isEmpty())
    <p class="text-gray-600 text-lg">No quizzes available yet. Check back soon!</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($quizzes as $quiz)
            @php
                $latestResult = $quiz->results()
                                    ->where('user_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->first();
                $attemptsCount = $quiz->results()
                                    ->where('user_id', auth()->id())
                                    ->count();
                $totalQuestions = $quiz->questions()->count();
                $progressPercent = $latestResult ? ($latestResult->score / max(1, $totalQuestions)) * 100 : 0;
            @endphp

            <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-lg transition-shadow duration-300">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $quiz->title }}</h2>
                    <p class="text-gray-500 mb-2">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

                    @if($latestResult)
                        <p class="text-green-700 font-semibold mb-1">
                            Latest Score: {{ $latestResult->score }} / {{ $latestResult->total }}
                        </p>
                        <p class="text-gray-500 text-sm mb-2">Attempts: {{ $attemptsCount }}</p>
                    @else
                        <p class="text-gray-500 mb-2">Not taken yet</p>
                    @endif

                    {{-- Progress Bar --}}
                    <div class="w-full bg-gray-200 rounded h-3 mt-2">
                        <div class="bg-blue-500 h-3 rounded" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ round($progressPercent) }}% Complete</p>
                </div>

                <a href="{{ route('user.quizzes.show', $quiz->id) }}"
                   class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-lg text-center font-medium hover:bg-blue-600 transition-colors">
                   @if($latestResult) Retake Quiz @else Take Quiz @endif
                </a>
            </div>
        @endforeach
    </div>
@endif
@endsection
