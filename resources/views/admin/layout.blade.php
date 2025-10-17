<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Admin') • QuickLearn</title>
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
    x-init="feather.replace()"
    :class="open ? 'w-64' : 'w-20'"
    class="bg-white border-r shadow-md flex flex-col transition-all duration-300 overflow-hidden"
  >
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b">
      <span x-show="open" class="font-bold text-xl truncate">QuickLearn Admin</span>
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

      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.dashboard') }}">
        <i data-feather="home"></i>
        <span x-show="open" class="truncate">Dashboard</span>
      </a>

      <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.categories.*') }}">
        <i data-feather="folder"></i>
        <span x-show="open" class="truncate">Categories</span>
      </a>

      <a href="{{ route('admin.lessons.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.lessons.*') }}">
        <i data-feather="book-open"></i>
        <span x-show="open" class="truncate">Lessons</span>
      </a>

      <a href="{{ route('admin.quizzes.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.quizzes.*') }}">
        <i data-feather="edit-3"></i>
        <span x-show="open" class="truncate">Quizzes</span>
      </a>

      <a href="{{ route('admin.questions.index') }}" class="flex items-center gap-3 p-2 rounded transition {{ $nav('admin.questions.*') }}">
        <i data-feather="help-circle"></i>
        <span x-show="open" class="truncate">Questions</span>
      </a>

      <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 p-2 rounded transition hover:bg-blue-100">
        <i data-feather="user"></i>
        <span class="truncate">User Dashboard</span>
      </a>
      
    </nav>

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
    feather.replace();
  </script>
</body>
</html>