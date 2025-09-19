@extends('user.layout')

@section('title', 'Quiz Result')

@section('content')
<div class="bg-white p-6 rounded shadow text-center">
    <h1 class="text-2xl font-bold mb-4">Quiz Result</h1>
    <p class="mb-4 text-lg">You scored <span class="font-bold text-green-700">{{ $score }}</span> out of <span class="font-bold">{{ $quiz->questions->count() }}</span>.</p>
    <a href="{{ route('user.quizzes.index') }}" class="text-blue-600 underline hover:text-blue-800">Back to Quizzes</a>
</div>
@endsection