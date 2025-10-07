@extends('user.layout')

@section('title', 'Dashboard')


@section('content')

<div class="flex items-center gap-4">
    <a href="{{ route('profile.edit') }}" class="flex items-center gap-4">
        @if(auth()->user()->profile_picture)
            <img src="{{ Storage::url(auth()->user()->profile_picture) }}" class="w-12 h-12 rounded-full">
        @else
            <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                {{ strtoupper(auth()->user()->name[0]) }}
            </div>
        @endif
        <span>{{ auth()->user()->name }}</span>
    </a>
</div>


<div class="max-w-7xl mx-auto space-y-12 py-6">

    <h1 class="text-3xl font-bold text-blue-600 mb-6">Welcome, {{ auth()->user()->name }}!</h1>

    {{-- Lessons Section --}}
    <section>
        <h2 class="text-2xl font-semibold mb-4">Lessons</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($lessons as $lesson)
                @php
                    $completed = $lesson->isCompletedByUser(auth()->id());
                @endphp
                <a href="{{ route('user.lessons.show', $lesson->id) }}" class="bg-white shadow-lg rounded-xl p-5 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-semibold text-lg mb-2">{{ $lesson->title }}</h3>
                        <p class="text-gray-600 mb-2">Category: {{ $lesson->category->name }}</p>
                        <p class="text-sm text-gray-500 line-clamp-3">{{ $lesson->content }}</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-sm font-medium {{ $completed ? 'text-green-600' : 'text-gray-400' }}">
                            {{ $completed ? 'Completed' : 'Not Completed' }}
                        </span>
                        @if($completed)
                            <i class="text-green-600" data-feather="check-circle"></i>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
</div>

<script>
    feather.replace();
</script>
@endsection
