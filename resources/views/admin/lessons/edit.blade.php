@extends('admin.layout')

@section('title','Edit Lesson')

@section('content')
  <h1 class="text-2xl font-semibold mb-6">Edit Lesson</h1>

  <form action="{{ route('admin.lessons.update',$lesson) }}" method="POST" class="space-y-6 max-w-lg">
    @csrf @method('PUT')

    <div>
      <label class="block mb-1 font-medium">Title</label>
      <input type="text" name="title" value="{{ $lesson->title }}" 
             class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500" required>
    </div>

    <div>
      <label class="block mb-1 font-medium">Content</label>
      <textarea name="content" rows="5" 
                class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500" required>{{ $lesson->content }}</textarea>
    </div>

    <div>
      <label class="block mb-1 font-medium">Category</label>
      <select name="category_id" 
              class="border rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-500" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" 
                  {{ $lesson->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>

    <label class="inline-flex items-center gap-2">
      <input type="checkbox" name="published" value="1" checked>
      <span>Published</span>
    </label>
    
    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
      Update
    </button>
  </form>
@endsection
