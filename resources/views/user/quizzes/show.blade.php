@extends('user.layout')

@section('title', $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6 sm:px-6">
  <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-blue-700">{{ $quiz->title }}</h1>
  <p class="mb-6 text-gray-600 text-sm sm:text-base">Lesson: {{ $quiz->lesson->title }}</p>

  <form action="{{ route('user.quizzes.submit', $quiz) }}" method="POST" class="space-y-6">
    @csrf

    @foreach($quiz->questions as $question)
      <div class="border border-gray-300 rounded-lg p-4 shadow-sm">
        <p class="font-semibold mb-3 text-sm sm:text-base">
          {{ $loop->iteration }}. {{ $question->question_text }}
        </p>

        <div class="space-y-2">
          @foreach($question->answers as $answer)
            <label class="flex items-center gap-2 text-sm sm:text-base">
              <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="accent-blue-500">
              <span>{{ $answer->text }}</span>
            </label>
          @endforeach
        </div>
      </div>
    @endforeach

    <div class="text-center">
      <button type="submit"
              class="w-full sm:w-auto bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
        Submit Quiz
      </button>
    </div>
  </form>
</div>
@endsection