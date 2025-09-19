@extends('admin.layout')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Edit Question</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="mb-1">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.questions.update', $question->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-semibold mb-1">Select Quiz</label>
            <select name="quiz_id" class="border p-2 w-full">
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" {{ $quiz->id == $question->quiz_id ? 'selected' : '' }}>
                        {{ $quiz->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold mb-1">Question Text</label>
            <input type="text" name="question_text" value="{{ old('question_text', $question->question_text) }}" class="border p-2 w-full" required>
        </div>

        <div>
            <label class="block font-semibold mb-2">Answers</label>

            <div id="answers-wrapper" class="space-y-3">
                @php
                    $existingAnswers = old('answers', $question->answers->toArray());
                @endphp

                @foreach($existingAnswers as $i => $answer)
                    <div class="answer-row flex items-center gap-2" data-index="{{ $i }}">
                        <input type="text"
                               name="answers[{{ $i }}][text]"
                               value="{{ $answer['text'] ?? $answer->text ?? '' }}"
                               class="border p-2 flex-1"
                               placeholder="Answer {{ $i + 1 }}" required>

                        <label class="flex items-center gap-1">
                            <input type="checkbox"
                                   name="answers[{{ $i }}][is_correct]"
                                   value="1"
                                   {{ (isset($answer['is_correct']) && $answer['is_correct']) || (isset($answer->is_correct) && $answer->is_correct) ? 'checked' : '' }}>
                            <span class="text-sm">Correct</span>
                        </label>

                        <button type="button" class="remove-answer bg-red-500 text-white px-2 py-1 rounded">Remove</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-3">
                <button type="button" id="add-answer" class="bg-gray-600 text-white px-3 py-1 rounded">
                    + Add Answer
                </button>
            </div>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Question</button>
            <a href="{{ route('admin.questions.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
        </div>
    </form>
</div>

<script>
    (function () {
        const wrapper = document.getElementById('answers-wrapper');
        // Start index from existing highest index + 1
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

        // Add new answer row
        document.getElementById('add-answer').addEventListener('click', () => {
            const idx = answerIndex++;
            const row = document.createElement('div');
            row.className = 'answer-row flex items-center gap-2';
            row.setAttribute('data-index', idx);
            row.innerHTML = `
                <input type="text" name="answers[${idx}][text]" class="border p-2 flex-1" placeholder="Answer ${idx + 1}" required>
                <label class="flex items-center gap-1">
                    <input type="checkbox" name="answers[${idx}][is_correct]" value="1">
                    <span class="text-sm">Correct</span>
                </label>
                <button type="button" class="remove-answer bg-red-500 text-white px-2 py-1 rounded">Remove</button>
            `;
            wrapper.appendChild(row);
        });

        // Remove answer row (works for existing and new rows)
        wrapper.addEventListener('click', function (e) {
            if (e.target && e.target.matches('.remove-answer')) {
                const row = e.target.closest('.answer-row');
                if (!row) return;
                // Remove DOM row
                row.remove();
            }
        });
    })();
</script>
@endsection
