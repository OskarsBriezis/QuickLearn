@extends('user.layout')

@section('title', 'Lessons')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">
    <h1 class="text-3xl font-bold mb-6 text-blue-700">Lessons</h1>

    @if($lessons->isEmpty())
        <p class="text-gray-600">No lessons available yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lessons as $lesson)
                <div class="bg-white shadow-lg rounded-xl p-4 flex flex-col justify-between hover:shadow-2xl transition duration-200">
                    @if($lesson->media_url)
                        <img src="{{ $lesson->media_url }}" alt="{{ $lesson->title }}" class="rounded h-40 w-full object-cover mb-4">
                    @endif

                    <div>
                        <h2 class="text-xl font-semibold mb-2">{{ $lesson->title }}</h2>
                        <p class="text-gray-600 mb-2 line-clamp-3 break-words">
                            {{ Str::limit($lesson->content, 120) }}
                    </p>    

                    </div>

                    <div class="flex items-center justify-between mt-4">
                        @if($lesson->isCompletedByUser(auth()->id()))
                            <span class="text-green-600 font-semibold">Completed ✅</span>
                        @else
                            <span class="text-gray-500 font-semibold">Not Completed</span>
                        @endif
                        <a href="{{ route('user.lessons.show', $lesson->id) }}" 
                           class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                           View Lesson
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
