@extends('user.layout')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6 sm:px-6 space-y-8" >
  <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">User Dashboard</h1>

  <!-- Stat Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Categories</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ $categoriesCount }}</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Lessons</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ $lessonsCount }}</p>
    </div>
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow hover:shadow-lg transition">
      <h2 class="text-sm text-gray-500">Quizzes</h2>
      <p class="text-2xl sm:text-3xl font-bold">{{ $quizzesCount }}</p>
    </div>
  </div>

  <!-- Recent Lessons -->
  <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
    <h2 class="text-lg sm:text-xl font-bold mb-4 text-gray-800">Recent Lessons</h2>
    <ul class="space-y-2 text-sm sm:text-base">
      @forelse ($recentLessons as $lesson)
        <li class="border-b pb-2 text-gray-700">
          {{ $lesson->title }}
          <span class="text-gray-500 text-xs sm:text-sm">({{ $lesson->created_at->diffForHumans() }})</span>
        </li>
      @empty
        <li class="text-gray-500">No lessons yet.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection