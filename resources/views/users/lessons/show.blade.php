@extends('user.layout')

@section('title', $lesson->title)

@section('content')
<div class="max-w-4xl mx-auto p-4 md:p-6">
    <div class="bg-white shadow-lg rounded-xl p-6">
        <h1 class="text-3xl font-bold mb-4 text-blue-700">{{ $lesson->title }}</h1>

        @if($lesson->media_url)
            <div class="mb-6">
                <img src="{{ $lesson->media_url }}" alt="{{ $lesson->title }}" class="rounded w-full object-cover">
            </div>
        @endif

        <!-- Lesson Content -->
        <div class="prose max-w-none mb-6 break-words whitespace-pre-line">
            {!! e($lesson->content) !!}
        </div>

        <div class="flex justify-between items-center">
            @if($lesson->isCompletedByUser(auth()->id()))
                <span class="text-green-600 font-semibold">✅ Lesson Completed</span>
            @else
                <form action="{{ route('user.lessons.complete', $lesson->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                        Mark as Complete
                    </button>
                </form>
            @endif

            @if($lesson->quizzes->count())
                <a href="{{ route('user.quizzes.show', $lesson->quizzes->first()->id) }}" 
                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                   Take Quiz
                </a>
            @endif
        </div>
    </div>
</div>
@endsection
