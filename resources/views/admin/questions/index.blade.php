@extends('admin.layout')

@section('content')
<div class="p-6 max-w-6xl mx-auto">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Questions Management</h1>

  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
      {{ session('success') }}
    </div>
  @endif

  {{-- Quiz Filter --}}
  <form method="GET" action="{{ route('admin.questions.index') }}" class="mb-8">
    <label for="quiz" class="block text-sm font-medium text-gray-700 mb-2">Select Quiz:</label>
    <div class="flex flex-col sm:flex-row gap-4">
      <select name="quiz_id" id="quiz"
              class="border border-gray-300 rounded px-4 py-2 w-full sm:w-1/3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">-- All Quizzes --</option>
        @foreach($quizzes as $quiz)
          <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
            {{ $quiz->title }} ({{ $quiz->questions_count }})
          </option>
        @endforeach
      </select>
      <button type="submit"
              class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
        Filter
      </button>
    </div>
  </form>

  {{-- Questions List --}}
  @if($questions->isEmpty())
    <p class="text-gray-500">No questions found.</p>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($questions as $question)
        <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
          <div>
            <h2 class="text-lg font-bold text-gray-800 mb-2">Q{{ $question->id }}: {{ $question->question_text }}</h2>
            <p class="text-sm text-gray-500 mb-2">Quiz: {{ $question->quiz->title ?? 'N/A' }}</p>

            <div class="mt-2">
              <p class="text-sm font-semibold text-gray-700 mb-1">Answers:</p>
              <ul class="list-disc pl-5 space-y-1">
                @foreach($question->answers as $answer)
                  <li class="text-sm">
                    {{ $answer->text }}
                    @if($answer->is_correct)
                      <span class="text-green-600 font-bold">✅</span>
                    @else
                      <span class="text-red-600">❌</span>
                    @endif
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <div class="mt-4 flex gap-2">
            <a href="{{ route('admin.questions.edit', $question->id) }}"
               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">
              Edit
            </a>
            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this question?')">
              @csrf @method('DELETE')
              <button type="submit"
                      class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">
                Delete
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection