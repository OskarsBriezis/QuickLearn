@extends('admin.layout')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Question</h1>

  @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li class="mb-1">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-8">
    @csrf @method('PUT')

    {{-- Quiz Selection --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Select Quiz</label>
      <select name="quiz_id"
              class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @foreach ($quizzes as $quiz)
          <option value="{{ $quiz->id }}" {{ $quiz->id == $question->quiz_id ? 'selected' : '' }}>
            {{ $quiz->title }}
          </option>
        @endforeach
      </select>
    </div>

    {{-- Question Text --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Question Text</label>
      <input type="text" name="question_text" value="{{ old('question_text', $question->question_text) }}"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
             required>
    </div>

    {{-- Answers --}}
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">Answers</label>
      <div id="answers-wrapper" class="space-y-4">
        @php $existingAnswers = old('answers', $question->answers->toArray()); @endphp

        @foreach($existingAnswers as $i => $answer)
          <div class="answer-row flex items-center gap-3" data-index="{{ $i }}">
            <input type="text"
                   name="answers[{{ $i }}][text]"
                   value="{{ $answer['text'] ?? $answer->text ?? '' }}"
                   class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Answer {{ $i + 1 }}" required>

            <label class="flex items-center gap-1 text-sm text-gray-600">
              <input type="checkbox"
                     name="answers[{{ $i }}][is_correct]"
                     value="1"
                     {{ (isset($answer['is_correct']) && $answer['is_correct']) || (isset($answer->is_correct) && $answer->is_correct) ? 'checked' : '' }}>
              Correct
            </label>

            <button type="button"
                    class="remove-answer bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
              Remove
            </button>
          </div>
        @endforeach
      </div>

      <div class="mt-4">
        <button type="button" id="add-answer"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
          + Add Answer
        </button>
      </div>
    </div>

    {{-- Submit --}}
    <div class="flex items-center gap-4">
      <button type="submit"
              class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
        Update Question
      </button>
      <a href="{{ route('admin.questions.index') }}" class="text-gray-600 hover:underline">Cancel</a>
    </div>
  </form>
</div>

{{-- JavaScript --}}
<script>
(function () {
  const wrapper = document.getElementById('answers-wrapper');
  let answerIndex = (() => {
    const rows = wrapper.querySelectorAll('.answer-row');
    if (!rows.length) return 0;
    let max = -1;
    rows.forEach(r => {
      const idx = parseInt(r.getAttribute('data-index'), 10);
      if (!isNaN(idx) && idx > max) max = idx;
    });
    return max + 1;
  })();

  document.getElementById('add-answer').addEventListener('click', () => {
    const idx = answerIndex++;
    const row = document.createElement('div');
    row.className = 'answer-row flex items-center gap-3 mt-2';
    row.setAttribute('data-index', idx);
    row.innerHTML = `
      <input type="text" name="answers[${idx}][text]"
             class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
             placeholder="Answer ${idx + 1}" required>
      <label class="flex items-center gap-1 text-sm text-gray-600">
        <input type="checkbox" name="answers[${idx}][is_correct]" value="1">
        Correct
      </label>
      <button type="button"
              class="remove-answer bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
        Remove
      </button>
    `;
    wrapper.appendChild(row);
  });

  wrapper.addEventListener('click', function (e) {
    if (e.target && e.target.matches('.remove-answer')) {
      const row = e.target.closest('.answer-row');
      if (row) row.remove();
    }
  });
})();
</script>
@endsection