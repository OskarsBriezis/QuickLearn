@extends('admin.layout')

@section('title', 'Dashboard')

@section('breadcrumbs')
  <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
@endsection

@section('content')
<div class="p-4 sm:p-6 space-y-8 max-w-6xl mx-auto">

  <!-- Page Title -->
  <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Admin Dashboard</h1>

  <!-- Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Categories</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Category::count() }}</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Lessons</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Lesson::count() }}</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Quizzes</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Quiz::count() }}</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Questions</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Question::count() }}</p>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-white p-4 sm:p-6 rounded-lg shadow space-y-4">
    <h2 class="text-lg sm:text-xl font-bold text-gray-800">Quick Actions</h2>
    <div class="flex flex-wrap gap-3">
      <a href="{{ route('admin.categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">+ Add Category</a>
      <a href="{{ route('admin.lessons.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">+ Add Lesson</a>
      <a href="{{ route('admin.quizzes.create') }}" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition">+ Add Quiz</a>
      <a href="{{ route('admin.questions.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">+ Add Question</a>
    </div>
  </div>

  <!-- Recent Lessons -->
  <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-4">Recent Lessons</h2>
    <ul class="space-y-2 text-sm sm:text-base">
      @foreach (\App\Models\Lesson::latest()->take(5)->get() as $lesson)
        <li class="border-b pb-2 text-gray-700">
          {{ $lesson->title }}
          <span class="text-gray-500 text-xs sm:text-sm">({{ $lesson->created_at->diffForHumans() }})</span>
        </li>
      @endforeach
    </ul>
  </div>

</div>
@endsection