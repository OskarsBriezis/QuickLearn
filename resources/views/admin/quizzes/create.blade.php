@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto p-6">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Quiz</h1>

  <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-6 bg-white shadow-md rounded-lg p-6">
    @csrf

    {{-- Quiz Title --}}
    <div>
      <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title</label>
      <input type="text" name="title" id="title"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
             required>
    </div>

    {{-- Lesson Selection --}}
    <div>
      <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">Lesson</label>
      <select name="lesson_id" id="lesson_id"
              class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required>
        @foreach ($lessons as $lesson)
          <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
        @endforeach
      </select>
    </div>

    {{-- Question Limit --}}
    <div>
      <label for="question_limit" class="block text-sm font-medium text-gray-700 mb-1">Number of Questions per Attempt</label>
      <input type="number" name="question_limit" id="question_limit" value="{{ old('question_limit') }}"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      <p class="text-sm text-gray-500 mt-1">Leave empty to include all questions</p>
    </div>

    {{-- Submit --}}
    <div class="text-right">
      <button type="submit"
              class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
        Save Quiz
      </button>
    </div>
  </form>
</div>
@endsection