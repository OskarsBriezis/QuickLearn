@extends('user.layout')

@section('title', 'Results - ' . $quiz->title)

@section('content')
<div class="min-h-screen bg-gray-100 px-4 py-6 sm:px-6">
  <div class="max-w-6xl mx-auto space-y-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $quiz->title }} - Results</h1>

    @php
      $totalPoints = $quiz->questions->sum('points');
      $earnedPoints = 0;
    @endphp

    {{-- Individual Questions --}}
    @foreach($quiz->questions as $index => $question)
      @php
        $userAnswerIds = $result->answers->where('question_id', $question->id)->pluck('id')->sort()->values()->toArray();
        $correctAnswerIds = $question->answers->where('is_correct', 1)->pluck('id')->sort()->values()->toArray();
        $isCorrect = $userAnswerIds === $correctAnswerIds;
        $questionEarnedPoints = $isCorrect ? $question->points : 0;
        $earnedPoints += $questionEarnedPoints;
        $userAnswers = $result->answers->where('question_id', $question->id);
        $correctAnswers = $question->answers->where('is_correct', 1);
      @endphp

      <div class="flex flex-col md:flex-row gap-4 bg-transparent">
        {{-- Sidebar --}}
        <div class="w-full md:w-32 flex-shrink-0 flex flex-col items-center justify-center
                    {{ $isCorrect ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}
                    rounded-xl p-4">
          <span class="font-bold text-lg">Q{{ $index + 1 }}</span>
          <span class="text-sm">{{ $questionEarnedPoints }}/{{ $question->points }} pts</span>
          <span class="text-xl">{{ $isCorrect ? '✅' : '❌' }}</span>
        </div>

        {{-- Question Box --}}
        <div class="flex-1 bg-white shadow-md rounded-xl p-4 sm:p-6">
          <p class="font-semibold text-base sm:text-lg mb-4">
            {{ $question->question_text }}
            <span class="text-gray-500 text-sm">({{ $question->points }} pts)</span>
          </p>

          {{-- User Answers --}}
          <div class="space-y-2">
            @forelse($userAnswers as $ua)
              @php $answerCorrect = $question->answers->find($ua->id)->is_correct; @endphp
              <p class="flex justify-between font-medium {{ $answerCorrect ? 'text-green-600' : 'text-red-600' }}">
                <span>{{ $ua->text }}</span>
                <span>{{ $answerCorrect ? '✅' : '❌' }}</span>
              </p>
            @empty
              <p class="text-gray-500 italic">No answer provided</p>
            @endforelse
          </div>

          {{-- Correct Answers --}}
          <div class="mt-4 pl-3 border-l-2 border-blue-200 space-y-1">
            @foreach($correctAnswers as $ca)
              <p class="text-green-700 font-medium">{{ $ca->text }}</p>
            @endforeach
          </div>
        </div>
      </div>
    @endforeach

    @php $percentage = $totalPoints ? round(($earnedPoints / $totalPoints) * 100) : 0; @endphp

    {{-- Overall Score --}}
    <div>
      <p class="text-lg sm:text-xl font-semibold">Score: {{ $earnedPoints }} / {{ $totalPoints }}</p>
      <div class="w-full bg-gray-200 rounded h-4 sm:h-6 mt-2">
        <div class="bg-green-500 h-4 sm:h-6 rounded" style="width: {{ $percentage }}%"></div>
      </div>
      <p class="text-sm sm:text-base text-gray-700 mt-2">{{ $percentage }}% Correct</p>
    </div>

    <div class="mt-6">
      <a href="{{ route('user.history.quizzes', ['category' => $quiz->lesson->category_id]) }}"
         class="text-blue-600 hover:underline text-sm sm:text-base">← Back to History</a>
    </div>
  </div>
</div>
@endsection