@extends('admin.layout')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Add Questions</h1>
    <form action="{{ route('admin.questions.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label class="block font-semibold">Select Quiz</label>
            <select name="quiz_id" class="border p-2 w-full" required>
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}">{{ $quiz->title }}</option>
                @endforeach
            </select>
        </div>

        <div id="questions-wrapper" class="space-y-6">
            <div class="question-block border p-4 rounded bg-gray-50">
                <label class="block font-semibold">Question Text</label>
                <input type="text" name="questions[0][text]" class="border p-2 w-full mb-2" required>

                <label class="block font-semibold mb-2">Points</label>
                <input type="number" name="questions[0][points]" value="1" min="1" class="border p-2 w-full mb-2">

                <label class="block font-semibold mb-2">Answers</label>
                <div class="answers space-y-2">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="flex items-center gap-2">
                            <input type="text" name="questions[0][answers][{{ $i }}][text]" class="border p-2 flex-1" placeholder="Answer {{ $i+1 }}" required>
                            <input type="checkbox" name="questions[0][answers][{{ $i }}][is_correct]" value="1">
                            <span>Correct</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <button type="button" id="add-question" class="bg-gray-500 text-white px-4 py-2 rounded">+ Add Another Question</button>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Save All</button>
    </form>
</div>

<script>
let questionIndex = 1;

document.getElementById('add-question').addEventListener('click', function () {
    let wrapper = document.getElementById('questions-wrapper');
    let newBlock = document.createElement('div');
    newBlock.classList.add('question-block', 'border', 'p-4', 'rounded', 'bg-gray-50', 'mt-4');

    newBlock.innerHTML = `
        <label class="block font-semibold">Question Text</label>
        <input type="text" name="questions[${questionIndex}][text]" class="border p-2 w-full mb-2" required>

        <label class="block font-semibold mb-2">Points</label>
        <input type="number" name="questions[${questionIndex}][points]" value="1" min="1" class="border p-2 w-full mb-2">

        <label class="block font-semibold mb-2">Answers</label>
        <div class="answers space-y-2">
            ${[0,1,2,3].map(i => `
                <div class="flex items-center gap-2">
                    <input type="text" name="questions[${questionIndex}][answers][${i}][text]" class="border p-2 flex-1" placeholder="Answer ${i+1}" required>
                    <input type="checkbox" name="questions[${questionIndex}][answers][${i}][is_correct]" value="1">
                    <span>Correct</span>
                </div>
            `).join('')}
        </div>
    `;
    wrapper.appendChild(newBlock);
    questionIndex++;
});
</script>
@endsection
