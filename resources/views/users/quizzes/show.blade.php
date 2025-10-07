@extends('user.layout')

@section('title', $quiz->title)

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-to-b from-blue-100 via-blue-200 to-blue-300 text-gray-900">
    <div class="bg-white shadow-2xl rounded-xl max-w-3xl w-full p-8">
        <h1 class="text-2xl font-bold mb-6 text-center">{{ $quiz->title }}</h1>
        <p class="mb-6 text-gray-600 text-center">Lesson: {{ $quiz->lesson->title ?? 'N/A' }}</p>

        <form id="quizForm" action="{{ route('user.quizzes.submit', $quiz->id) }}" method="POST">
            @csrf
            @foreach($quiz->questions as $index => $question)
                <div class="question mb-6 @if($index != 0) hidden @endif">
                    <p class="font-semibold mb-2">Q{{ $index + 1 }}: {{ $question->question_text }}</p>
                    @foreach($question->answers as $answer)
                        <label class="block mt-1 cursor-pointer">
                            <input type="{{ $question->answers->where('is_correct', 1)->count() > 1 ? 'checkbox' : 'radio' }}" 
                                   name="answers[{{ $question->id }}]{{ $question->answers->where('is_correct', 1)->count() > 1 ? '[]' : '' }}" 
                                   value="{{ $answer->id }}">
                            {{ $answer->text }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <div class="flex justify-between items-center mt-6">
                <button type="button" id="prevBtn" class="px-4 py-2 rounded text-white bg-gray-400 cursor-not-allowed">Previous</button>
                <span id="progressIndicator" class="text-gray-700 font-medium"></span>
                <div class="flex gap-2">
                    <button type="button" id="nextBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
                    <button type="submit" id="submitBtn" class="bg-green-500 text-white px-4 py-2 rounded hidden">Submit Quiz</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const questions = document.querySelectorAll('.question');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');
const progressIndicator = document.getElementById('progressIndicator');
let currentIndex = 0;

function showQuestion(index) {
    questions.forEach((q, i) => q.classList.toggle('hidden', i !== index));
    prevBtn.disabled = index === 0;
    prevBtn.classList.toggle('bg-gray-400', index === 0);
    prevBtn.classList.toggle('cursor-not-allowed', index === 0);
    nextBtn.classList.toggle('hidden', index === questions.length - 1);
    submitBtn.classList.toggle('hidden', index !== questions.length - 1);
    progressIndicator.textContent = `Question ${index + 1} of ${questions.length}`;
}

prevBtn.addEventListener('click', () => { if(currentIndex > 0) currentIndex--; showQuestion(currentIndex); });
nextBtn.addEventListener('click', () => { if(currentIndex < questions.length - 1) currentIndex++; showQuestion(currentIndex); });

showQuestion(currentIndex);
</script>
@endsection
