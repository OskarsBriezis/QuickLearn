@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Quiz</h1>

    <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block mb-1">Quiz Title</label>
            <input type="text" name="title" value="{{ $quiz->title }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1">Lesson</label>
            <select name="lesson_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($lessons as $lesson)
                    <option value="{{ $lesson->id }}" @if($quiz->lesson_id == $lesson->id) selected @endif>{{ $lesson->title }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-semibold">Question Limit</label>
            <input type="number" name="question_limit" value="{{ old('question_limit', $quiz->question_limit) }}" class="border p-2 w-full">
            <small class="text-gray-500">Leave empty for no limit</small>
    </div>


        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
    </form>
</div>
@endsection
