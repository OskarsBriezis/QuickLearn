@extends('admin.layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Add New Quiz</h1>

    <form method="POST" action="{{ route('admin.quizzes.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Quiz Title</label>
            <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1">Lesson</label>
            <select name="lesson_id" class="w-full border rounded px-3 py-2" required>
                @foreach ($lessons as $lesson)
                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block font-semibold mb-1"> Number of Questions per Attemp </label>
            <input type="number" name="question_limit" value="{{ old('question_limit') }}" class="border p-2 w-full">
            <p class="text-gray-500 text-sm" >Leave empty to include all questions</p>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
    </form>
</div>
@endsection
