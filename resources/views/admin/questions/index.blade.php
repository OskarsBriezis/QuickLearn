@extends('admin.layout')

@section('content')
<div class="p-6">
    <h1 class="text-xl font-bold mb-4">Questions Management</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Step 1: Select a quiz --}}
    <form method="GET" action="{{ route('admin.questions.index') }}" class="mb-6">
        <label for="quiz" class="block font-semibold mb-2">Select Quiz:</label>
        <select name="quiz_id" id="quiz" class="border rounded px-3 py-2 w-full md:w-1/3">
            <option value="">-- All Quizzes --</option>
            @foreach($quizzes as $quiz)
                <option value="{{ $quiz->id }}" {{ request('quiz_id') == $quiz->id ? 'selected' : '' }}>
                    {{ $quiz->title }} ({{ $quiz->questions_count }})
                </option>
            @endforeach
        </select>
        <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Filter
        </button>
    </form>

    {{-- Step 2: Show filtered questions --}}
    @if($questions->isEmpty())
        <p class="text-gray-500">No questions found.</p>
    @else
        <table class="w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Quiz</th>
                    <th class="p-2 border">Question</th>
                    <th class="p-2 border">Answers</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questions as $question)
                    <tr>
                        <td class="p-2 border">{{ $question->id }}</td>
                        <td class="p-2 border">{{ $question->quiz->title ?? 'N/A' }}</td>
                        <td class="p-2 border">{{ $question->question_text }}</td>
                        <td class="p-2 border">
                            <ul class="list-disc pl-4">
                                @foreach($question->answers as $answer)
                                    <li>
                                        {{ $answer->text }}
                                        @if($answer->is_correct)
                                            <span class="text-green-600 font-bold">✅</span>
                                        @else
                                            <span class="text-red-600">❌</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="p-2 border space-x-2">
                            <a href="{{ route('admin.questions.edit', $question->id) }}" 
                               class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure?')" 
                                        class="bg-red-500 text-white px-2 py-1 rounded">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
