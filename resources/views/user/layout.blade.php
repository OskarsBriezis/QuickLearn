<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','User') • QuickLearn</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://unpkg.com/feather-icons"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
  <style>
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(20px); }
      100% { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up {
      animation: fadeInUp 0.5s ease-out;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 flex min-h-screen transition-colors duration-300">

  <!-- Sidebar -->
  <aside
  x-data="{
    open: localStorage.getItem('sidebarOpen') === 'true',
    toggle() {
      this.open = !this.open;
      localStorage.setItem('sidebarOpen', this.open);
    }
  }"
  :class="open ? 'w-64' : 'w-20'"
  class="bg-white border-r shadow-md flex flex-col transition-all duration-300 overflow-hidden"
>
  <!-- Header -->
  <div class="flex items-center justify-between p-4 border-b">
    <span x-show="open" class="font-bold text-xl truncate">QuickLearn User</span>
    <button @click="toggle" class="p-1 hover:bg-gray-200 rounded">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" :class="open ? '' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>
  </div>


    <!-- Navigation -->
    <nav class="flex-1 flex flex-col p-2 gap-1">
      @php
        $nav = fn($route) => request()->routeIs($route) ? 'bg-blue-100 text-blue-700 font-semibold' : 'hover:bg-blue-100';
      @endphp

      <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('user.dashboard') }}">
        <i data-feather="home"></i>
        <span x-show="open" class="truncate">Dashboard</span>
      </a>

      <a href="{{ route('user.categories.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('user.categories.*') }}">
        <i data-feather="folder"></i>
        <span x-show="open" class="truncate">Categories</span>
      </a>

      <a href="{{ route('user.lessons.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('user.lessons.*') }}">
        <i data-feather="book-open"></i>
        <span x-show="open" class="truncate">Lessons</span>
      </a>

      <a href="{{ route('user.quizzes.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('user.quizzes.*') }}">
        <i data-feather="edit-3"></i>
        <span x-show="open" class="truncate">Quizzes</span>
      </a>

      <a href="{{ route('user.history.categories') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('user.history.categories') }}">
        <i data-feather="clock"></i>
        <span x-show="open" class="truncate">History</span>
      </a>

      <a href="{{ route('user.profile.edit') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100">
        <i data-feather="user"></i>
        <span x-show="open" class="truncate">Profile</span>
      </a>


      @if(auth()->user()->is_admin)
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.*') }}">
          <i data-feather="settings"></i>
          <span x-show="open" class="truncate">Admin</span>
        </a>
      @endif
    </nav>

    <!-- User & Logout with Profile Picture -->
<div class="p-4 border-t flex items-center gap-3 text-gray-700">
 @php
  $profilePath = auth()->user()->profile_picture
    ? asset('storage/' . auth()->user()->profile_picture)
    : asset('images/default-avatar.jpg');
@endphp

<img src="{{ $profilePath }}"
     alt="{{ auth()->user()->name }}'s profile picture"
     class="w-10 h-10 rounded-full object-cover shadow">


  <div class="flex-1 flex flex-col justify-center" x-show="open">
    <span class="font-medium truncate">{{ auth()->user()->name }}</span>
    <form action="/logout" method="POST" class="inline">
      @csrf
      <button class="text-sm underline hover:text-red-600 transition" title="Logout">Logout</button>
    </form>
  </div>
</div>
</aside>

  <!-- Main content -->
  <main class="flex-1 px-4 py-6 sm:px-6 fade-in-up">
    @if(session('success'))
      <div class="max-w-4xl mx-auto mt-4 p-3 bg-green-100 border border-green-300 rounded shadow-lg transform transition hover:scale-105">
        {{ session('success') }}
      </div>
    @endif

    @yield('content')
  </main>

  <script>
    feather.replace()
  </script>
</body>
</html>