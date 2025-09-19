@extends('user.layout')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-12 py-6">

    <h1 class="text-3xl font-bold text-blue-600 mb-6">Welcome, {{ auth()->user()->name }}!</h1>

    {{-- Lessons Section --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Lessons</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lessons as $lesson)
                @php
                    $completed = $lesson->isCompletedByUser(auth()->id());
                @endphp
                <a href="{{ route('user.lessons.show', $lesson->id) }}" class="bg-white shadow-lg rounded-xl p-5 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">{{ $lesson->title }}</h3>
                        <p class="text-gray-600 mb-2">Category: {{ $lesson->category->name }}</p>
                        <p class="text-sm text-gray-500 line-clamp-3">{{ $lesson->content }}</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-medium {{ $completed ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $completed ? 'Completed' : 'Not Completed' }}
                        </span>
                        @if($completed)
                            <i class="text-green-600" data-feather="check-circle"></i>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Quizzes Section --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Quizzes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($quizzes as $quiz)
    @php
        $latestResult = $quiz->results()
                            ->where('user_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->first();

        // Total points for the quiz
        $totalPoints = $quiz->questions->sum('points');

        // Earned points from this attempt
        $earnedPoints = $latestResult 
            ? $quiz->questions->sum(function ($question) use ($latestResult) {
                $userAnswers = $latestResult->answers->where('question_id', $question->id)->pluck('answer_id')->toArray();
                $correctAnswers = $question->answers->where('is_correct', 1)->pluck('id')->toArray();
                $isCorrect = collect($userAnswers)->sort()->values()->toArray() === collect($correctAnswers)->sort()->values()->toArray();
                return $isCorrect ? $question->points : 0;
            }) 
            : 0;

        $progressPercent = $totalPoints ? ($earnedPoints / $totalPoints) * 100 : 0;
    @endphp

    <div class="bg-white shadow-lg rounded-xl p-5 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col justify-between">
        <div>
            <h3 class="font-semibold text-lg mb-2">{{ $quiz->title }}</h3>
            <p class="text-gray-600 mb-3">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

            <div class="w-full bg-gray-200 h-3 rounded-full overflow-hidden">
                <div class="h-3 rounded-full bg-blue-500" style="width: {{ $progressPercent }}%"></div>
            </div>
            <p class="text-sm text-gray-600 mt-1">{{ round($progressPercent) }}% Complete</p>
        </div>

        <a href="{{ route('user.quizzes.show', $quiz->id) }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded text-center hover:bg-blue-600 transition">
            @if($latestResult) Retake Quiz @else Take Quiz @endif
        </a>
    </div>
@endforeach

        </div>
    </section>

</div>

<script>
    feather.replace();
</script>
@endsection
