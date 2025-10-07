@extends('user.layout')

@section('title', $category->name)

@section('content')
<h1 class="text-3xl font-bold mb-6">{{ $category->name }}</h1>
<p class="mb-6 text-gray-600">{{ $category->description }}</p>

<h2 class="text-2xl font-semibold mb-4">Lessons in this category</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($category->lessons as $lesson)
        @php
            $totalQuizzes = $lesson->quizzes->count();
            $completedQuizzes = $lesson->quizzes->filter(fn($quiz) => $quiz->results->where('user_id', auth()->id())->count() > 0)->count();
            $percent = $totalQuizzes > 0 ? ($completedQuizzes / $totalQuizzes) * 100 : 0;
        @endphp

        <a href="{{ route('user.lessons.show', $lesson) }}" 
           class="bg-white shadow hover:shadow-lg transition rounded-lg p-5 flex flex-col justify-between">
            
            {{-- Lesson Title --}}
            <div>
                <h3 class="text-xl font-semibold mb-2">{{ $lesson->title }}</h3>
            </div>

            {{-- Quiz Progress Bar --}}
            @if($totalQuizzes > 0)
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-700">{{ $completedQuizzes }}/{{ $totalQuizzes }} Quizzes Completed</span>
                        <span class="text-sm text-gray-700">{{ round($percent) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 h-2 rounded">
                        <div class="bg-blue-500 h-2 rounded" style="width: {{ $percent }}%"></div>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-sm mt-2">No quizzes available yet.</p>
            @endif
        </a>
    @endforeach
</div>

{{-- Pagination if using paginate() --}}
@if(method_exists($category->lessons, 'links'))
    <div class="mt-6">
        {{ $category->lessons->links() }}
    </div>
@endif
@endsection
