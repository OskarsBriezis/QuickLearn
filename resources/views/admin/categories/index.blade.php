@extends('admin.layout')

@section('title','Categories')

@section('content')
  <h1 class="text-2xl font-semibold mb-6">Categories</h1>

  <div class="mt-6 overflow-x-auto">
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-4 py-2 text-left">ID</th>
          <th class="border px-4 py-2 text-left">Name</th>
          <th class="border px-4 py-2 text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($categories as $category)
        <tr class="odd:bg-white even:bg-gray-50">
          <td class="border px-4 py-2">{{ $category->id }}</td>
          <td class="border px-4 py-2">{{ $category->name }}</td>
          <td class="border px-4 py-2 text-center space-x-2">
            <a href="{{ route('admin.categories.edit',$category) }}" 
               class="bg-yellow-500 text-white px-3 py-1 rounded-lg hover:bg-yellow-600">Edit</a>
            <form action="{{ route('admin.categories.destroy',$category) }}" method="POST" class="inline">
              @csrf @method('DELETE')
              <button type="submit" 
                      class="bg-red-600 text-white px-3 py-1 rounded-lg hover:bg-red-700"
                      onclick="return confirm('Delete this category?')">
                Delete
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
