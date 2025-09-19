@extends('user.layout')

@section('title', 'Categories')

@section('content')
<h1 class="text-3xl font-bold mb-6">Choose a Category</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $category)
        @php
            $totalQuizzes = $category->lessons->sum(fn($lesson) => $lesson->quizzes->count());
            $completedQuizzes = $category->lessons->sum(fn($lesson) => 
                $lesson->quizzes->filter(fn($quiz) => $quiz->results->where('user_id', auth()->id())->count() > 0)->count()
            );
            $percent = $totalQuizzes > 0 ? ($completedQuizzes / $totalQuizzes) * 100 : 0;
        @endphp

        <a href="{{ route('user.categories.show', $category) }}" 
           class="bg-white shadow hover:shadow-lg transition rounded-lg p-5 flex flex-col justify-between">
            
            {{-- Category Title & Description --}}
            <div>
                <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
            </div>

            {{-- Quiz Progress Bar --}}
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm text-gray-700">{{ $completedQuizzes }}/{{ $totalQuizzes }} Quizzes Completed</span>
                    <span class="text-sm text-gray-700">{{ round($percent) }}%</span>
                </div>
                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="bg-blue-500 h-2 rounded" style="width: {{ $percent }}%"></div>
                </div>
            </div>
        </a>
    @endforeach
</div>

{{-- Pagination if using paginate() in controller --}}
@if(method_exists($categories, 'links'))
    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endif
@endsection
