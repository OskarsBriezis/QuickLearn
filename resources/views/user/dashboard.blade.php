@extends('user.layout')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 space-y-6">
    <h1 class="text-2xl font-bold mb-4">user Dashboard</h1>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Categories</h2>
            <p class="text-3xl font-bold">{{ \App\Models\Category::count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Lessons</h2>
            <p class="text-3xl font-bold">{{ \App\Models\Lesson::count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition">
            <h2 class="text-sm text-gray-500">Quizzes</h2>
            <p class="text-3xl font-bold">{{ \App\Models\Quiz::count() }}</p>
        </div>
    </div>

    <!-- Recent lessons -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-lg font-bold mb-3">Recent Lessons</h2>
        <ul class="space-y-2">
            @foreach (\App\Models\Lesson::latest()->take(5)->get() as $lesson)
                <li class="border-b pb-2">{{ $lesson->title }} <span class="text-gray-500 text-sm">({{ $lesson->created_at->diffForHumans() }})</span></li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
