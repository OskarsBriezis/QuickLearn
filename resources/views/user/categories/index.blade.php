@extends('user.layout')

@section('title','Categories')

@section('content')
<h1 class="text-2xl font-semibold mb-6">Categories</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
  @foreach($categories as $category)
    <div class="bg-white shadow-md rounded-lg p-6 flex flex-col justify-between">
      <div>
        <h2 class="text-lg font-bold text-gray-800 mb-2">📚 {{ $category->name }}</h2>
        <p class="text-sm text-gray-500">Category ID: {{ $category->id }}</p>
      </div>
      <div class="mt-4">
        <a href="{{ route('user.categories.show', $category) }}"
           class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
          View Lessons
        </a>
      </div>
    </div>
  @endforeach
</div>
@endsection