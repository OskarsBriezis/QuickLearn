@extends('user.layout')

@section('title', $lesson->title)

@section('content')
@php
  use Illuminate\Support\Str;

  $allLessons = \App\Models\Lesson::with('category')->get();
  $completedCount = $allLessons->filter(fn($l) => $l->isCompletedByUser(auth()->id()))->count();
  $totalCount = $allLessons->count();
  $progressPercent = $totalCount ? round(($completedCount / $totalCount) * 100) : 0;
  $nextLesson = $allLessons->first(fn($l) => !$l->isCompletedByUser(auth()->id()));
@endphp

<div class="max-w-4xl mx-auto px-4 py-6 sm:px-6 space-y-6">

  {{-- Progress Tracker --}}
  <div class="bg-white p-4 sm:p-6 rounded-lg shadow">
    <h2 class="text-lg font-bold text-gray-800 mb-2">Your Progress</h2>
    <div class="w-full bg-gray-200 rounded h-4 mb-2">
      <div class="bg-green-500 h-4 rounded" style="width: {{ $progressPercent }}%"></div>
    </div>
    <p class="text-sm text-gray-600">{{ $completedCount }} of {{ $totalCount }} lessons completed ({{ $progressPercent }}%)</p>
  </div>

  {{-- Continue Reading --}}
  @if($nextLesson && $nextLesson->id !== $lesson->id)
    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg shadow">
      <h2 class="text-lg font-bold text-blue-700 mb-2">Continue Reading</h2>
      <p class="text-gray-700 mb-2">{{ $nextLesson->title }}</p>
      <a href="{{ route('user.lessons.show', $nextLesson) }}"
         class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
        Resume Lesson
      </a>
    </div>
  @endif

  {{-- Current Lesson --}}
  <div class="bg-white shadow-lg rounded-xl p-4 sm:p-6">
    <h1 class="text-2xl sm:text-3xl font-bold mb-4 text-blue-700">{{ $lesson->title }}</h1>

    @if($lesson->media_url)
  <div class="mb-8">
    @php
      $url = $lesson->media_url;
      $isVideo = Str::endsWith($url, ['.mp4', '.webm', '.ogg']);
      $isImage = Str::endsWith($url, ['.jpg', '.jpeg', '.png', '.gif', '.webp']);
      $isYouTube = Str::contains($url, ['youtube.com', 'youtu.be']);
    @endphp

    @if($isYouTube)
      @php
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^\&\?\/]+)/', $url, $matches);
        $videoId = $matches[1] ?? null;
      @endphp

      @if($videoId)
        <div class="relative w-full overflow-hidden rounded-lg shadow-lg" style="padding-top: 56.25%;">
          <iframe
            class="absolute top-0 left-0 w-full h-full"
            src="https://www.youtube.com/embed/{{ $videoId }}"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
          ></iframe>
        </div>
      @else
        <p class="text-sm text-gray-500">Invalid YouTube link.</p>
      @endif

    @elseif($isVideo)
      <video src="{{ $url }}" class="w-full rounded-lg shadow-lg max-h-[700px]" controls></video>
    @elseif($isImage)
      <img src="{{ $url }}" alt="{{ $lesson->title }}" class="w-full rounded-lg shadow-lg max-h-[700px] object-contain">
    @else
      <p class="text-sm text-gray-500">Unsupported media format.</p>
    @endif
  </div>
@endif

    <!-- Lesson Content -->
    <div class="prose max-w-none mb-6 break-words whitespace-pre-line text-sm sm:text-base">
      {!! e($lesson->content) !!}
    </div>

    <!-- Completion Action -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
      @if($lesson->isCompletedByUser(auth()->id()))
        <span class="text-green-600 font-semibold text-sm sm:text-base">✅ Lesson Completed</span>
      @else
        <form action="{{ route('user.lessons.complete', $lesson->id) }}" method="POST">
          @csrf
          <button type="submit"
                  class="w-full sm:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Mark as Complete
          </button>
        </form>
      @endif
    </div>
  </div>
</div>
@endsection