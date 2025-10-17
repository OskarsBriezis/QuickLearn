@extends('user.layout')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-xl mx-auto px-4 py-6 space-y-6">
  @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded">
      {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="space-y-6" x-data="{ preview: null }">
    @csrf
    @method('PATCH')

    {{-- Name --}}
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
      <input name="name" id="name" value="{{ old('name', $user->name) }}"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
      @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Email --}}
    <div>
      <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
      <input name="email" id="email" type="email" value="{{ old('email', $user->email) }}"
             class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
      @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Profile Picture --}}
    <div>
      <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
      <input type="file" name="profile_picture" id="profile_picture"
             @change="preview = URL.createObjectURL($event.target.files[0])"
             class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
      @error('profile_picture') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

      {{-- Live Preview --}}
      <template x-if="preview">
        <img :src="preview" alt="Preview" class="mt-4 w-32 h-32 rounded-full object-cover shadow">
      </template>

      {{-- Existing Picture --}}
      @if($user->profile_picture && !old('profile_picture'))
        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture"
             class="mt-4 w-32 h-32 rounded-full object-cover shadow">
      @endif
    </div>

    {{-- Password Update --}}
<div>
  <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
  <input type="password" name="password" id="password"
         class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500"
         placeholder="Leave blank to keep current password">
  @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div>
  <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
  <input type="password" name="password_confirmation" id="password_confirmation"
         class="w-full border border-gray-300 rounded px-4 py-2 focus:ring-2 focus:ring-blue-500">
</div>


    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
      Save Changes
    </button>
  </form>
</div>
@endsection