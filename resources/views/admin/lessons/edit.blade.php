@extends('admin.layout')
@section('title','Edit Lesson')

@section('content')
<h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Lesson</h1>

<div class="bg-white shadow-md rounded-lg p-6 max-w-2xl mx-auto">
  <form method="POST" action="{{ route('admin.lessons.update', $lesson) }}" class="space-y-6">
    @csrf @method('PUT')

    {{-- Title --}}
    <div>
      <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
      <input name="title" id="title" value="{{ old('title', $lesson->title) }}"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Content --}}
    <div>
      <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
      <textarea name="content" id="content" rows="8"
                class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $lesson->content) }}</textarea>
      @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Category --}}
    <div>
      <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
      <select name="category_id" id="category_id"
              class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">-- Select Category --</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ $lesson->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
      @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Media URL --}}
<div x-data="{ url: '{{ old('media_url', $lesson->media_url) }}' }">
  <label for="media_url" class="block text-sm font-medium text-gray-700 mb-1">Media URL</label>
  <input
    name="media_url"
    id="media_url"
    x-model="url"
    placeholder="https://example.com/video.mp4 or image.jpg or YouTube link"
    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
  >
  @error('media_url') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

  {{-- Live Preview --}}
  <div class="mt-4" x-show="url">
    <template x-if="url.includes('youtube.com') || url.includes('youtu.be')">
      <iframe
        :src="`https://www.youtube.com/embed/${url.split('v=')[1]?.split('&')[0] || url.split('/').pop()}`"
        class="w-full rounded max-h-96"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen
      ></iframe>
    </template>

    <template x-if="url.endsWith('.mp4') || url.endsWith('.webm') || url.endsWith('.ogg')">
      <video :src="url" class="w-full rounded max-h-64" controls></video>
    </template>

    <template x-if="url.endsWith('.jpg') || url.endsWith('.jpeg') || url.endsWith('.png') || url.endsWith('.gif') || url.endsWith('.webp')">
      <img :src="url" alt="Media preview" class="w-full rounded max-h-64 object-cover">
    </template>

    <template x-if="!url.includes('youtube.com') && !url.includes('youtu.be') && !url.endsWith('.mp4') && !url.endsWith('.webm') && !url.endsWith('.ogg') && !url.endsWith('.jpg') && !url.endsWith('.jpeg') && !url.endsWith('.png') && !url.endsWith('.gif') && !url.endsWith('.webp')">
      <p class="text-sm text-gray-500">Preview not available for this format.</p>
    </template>
  </div>
</div>

    {{-- Published --}}
    <div class="flex items-center gap-2">
      <input type="checkbox" name="published" value="1" {{ $lesson->published ? 'checked' : '' }}>
      <span class="text-sm text-gray-700">Published</span>
    </div>

    {{-- Submit --}}
    <div class="text-right">
      <button type="submit"
              class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
        Save Changes
      </button>
    </div>
  </form>
</div>
@endsection