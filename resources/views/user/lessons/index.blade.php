@extends('user.layout')

@section('title','Lessons')

@section('content')
  <h1 class="text-2xl font-semibold mb-6">Lessons</h1>

  <div class="mt-6 overflow-x-auto">
    <table class="w-full border border-gray-300 rounded-lg overflow-hidden">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-4 py-2 text-left">ID</th>
          <th class="border px-4 py-2 text-left">Title</th>
          <th class="border px-4 py-2 text-left">Category</th>
        </tr>
      </thead>
      <tbody>
        @foreach($lessons as $lesson)
        <tr class="odd:bg-white even:bg-gray-50">
          <td class="border px-4 py-2">{{ $lesson->id }}</td>
          <td class="border px-4 py-2">{{ $lesson->title }}</td>
          <td class="border px-4 py-2">{{ $lesson->category->name ?? '—' }}</td>
          <td class="border px-4 py-2 text-center space-x-2">
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
