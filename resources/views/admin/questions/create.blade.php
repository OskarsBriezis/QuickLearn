@extends('admin.layout')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Add Questions to Quiz</h1>

  <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-8">
    @csrf

    {{-- Quiz Selection --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Select Quiz</label>
      <select name="quiz_id"
              class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              required>
        @foreach ($quizzes as $quiz)
          <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
        @endforeach
      </select>
    </div>

    {{-- Questions Wrapper --}}
    <div id="questions-wrapper" class="space-y-8">
      <div class="question-block bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Question 1</h2>

        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
            <input type="text" name="questions[0][text]"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   required>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
            <input type="number" name="questions[0][points]" value="1" min="1"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Answers</label>
            <div class="space-y-3">
              @for ($i = 0; $i < 4; $i++)
                <div class="flex items-center gap-3">
                  <input type="text" name="questions[0][answers][{{ $i }}][text]"
                         class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                         placeholder="Answer {{ $i+1 }}" required>
                  <label class="flex items-center gap-1 text-sm text-gray-600">
                    <input type="checkbox" name="questions[0][answers][{{ $i }}][is_correct]" value="1">
                    Correct
                  </label>
                </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Buttons --}}
    <div class="flex gap-4">
      <button type="button" id="add-question"
              class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
        + Add Another Question
      </button>
      <button type="submit"
              class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
        Save All
      </button>
    </div>
  </form>
</div>

{{-- JavaScript --}}
<script>
let questionIndex = 1;

document.getElementById('add-question').addEventListener('click', function () {
  const wrapper = document.getElementById('questions-wrapper');
  const newBlock = document.createElement('div');
  newBlock.classList.add('question-block', 'bg-white', 'border', 'border-gray-300', 'rounded-lg', 'p-6', 'shadow-sm');

  newBlock.innerHTML = `
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Question ${questionIndex + 1}</h2>
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
        <input type="text" name="questions[${questionIndex}][text]"
               class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
               required>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Points</label>
        <input type="number" name="questions[${questionIndex}][points]" value="1" min="1"
               class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Answers</label>
        <div class="space-y-3">
          ${[0,1,2,3].map(i => `
            <div class="flex items-center gap-3">
              <input type="text" name="questions[${questionIndex}][answers][${i}][text]"
                     class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                     placeholder="Answer ${i+1}" required>
              <label class="flex items-center gap-1 text-sm text-gray-600">
                <input type="checkbox" name="questions[${questionIndex}][answers][${i}][is_correct]" value="1">
                Correct
              </label>
            </div>
          `).join('')}
        </div>
      </div>
    </div>
  `;
  wrapper.appendChild(newBlock);
  questionIndex++;
});
</script>
@endsection