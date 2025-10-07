@extends('user.layout')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Quizzes</h1>

    <table class="w-full mt-6 border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Lesson</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quizzes as $quiz)
            <tr>
                <td class="border px-4 py-2">{{ $quiz->id }}</td>
                <td class="border px-4 py-2">{{ $quiz->title }}</td>
                <td class="border px-4 py-2">{{ $quiz->lesson->title }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
