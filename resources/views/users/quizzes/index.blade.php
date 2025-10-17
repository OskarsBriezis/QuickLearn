@extends('user.layout')

@section('title', 'Quizzes')

@section('content')
<h1 class="text-3xl font-bold mb-6">Available Quizzes</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($quizzes as $quiz)
        @php
            $completed = $quiz->results->where('user_id', auth()->id())->count() > 0;
        @endphp

        <a href="{{ route('user.quizzes.show', $quiz) }}" 
           class="bg-white shadow hover:shadow-lg transition rounded-lg p-5 flex flex-col justify-between">
            
            <div>
                <h2 class="text-xl font-semibold mb-2">{{ $quiz->title }}</h2>
                <p class="text-gray-600 mb-4">Lesson: {{ $quiz->lesson->title }}</p>
            </div>

            <div>
                <span class="text-sm text-gray-700">
                    {{ $completed ? 'Completed' : 'Not Attempted' }}
                </span>
            </div>
        </a>
    @endforeach
</div>

@if(method_exists($quizzes, 'links'))
    <div class="mt-6">
        {{ $quizzes->links() }}
    </div>
@endif
@endsection
