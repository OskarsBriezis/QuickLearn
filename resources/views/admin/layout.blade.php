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
  <aside x-data="{ open: true }" :class="open ? 'w-64' : 'w-20'" class="bg-white min-h-screen border-r shadow-md flex flex-col transition-all duration-300">
    <!-- Header -->
    <div class="flex items-center justify-between p-4 border-b">
      <span x-show="open" class="font-bold text-xl truncate">QuickLearn Admin</span>
      <button @click="open = !open" class="p-1 hover:bg-gray-200 rounded">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform duration-300" :class="open ? '' : 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 flex flex-col p-2 gap-1">
      <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100 transition-colors duration-300" title="Dashboard">
        <i data-feather="home"></i>
        <span x-show="open" class="truncate">Dashboard</span>
      </a>

      <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100 transition-colors duration-300">
  <i data-feather="folder"></i>
  <span x-show="open" class="truncate">Categories</span>
</a>

<a href="{{ route('admin.lessons.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100 transition-colors duration-300">
  <i data-feather="book-open"></i>
  <span x-show="open" class="truncate">Lessons</span>
</a>

<a href="{{ route('admin.quizzes.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100 transition-colors duration-300">
  <i data-feather="edit-3"></i>
  <span x-show="open" class="truncate">Quizzes</span>
</a>

<a href="{{ route('admin.questions.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-blue-100 transition-colors duration-300">
  <i data-feather="help-circle"></i>
  <span x-show="open" class="truncate">Questions</span>
</a>
    </nav>

    <!-- User & Logout -->
    <div class="p-4 border-t flex items-center justify-between text-gray-700">
      <span x-show="open" class="font-medium truncate">{{ auth()->user()->name }}</span>
      <form action="/logout" method="POST" class="inline">
        @csrf
        <button class="underline hover:text-red-600 transition-colors duration-300" title="Logout">Logout</button>
      </form>
    </div>
  </aside>

  <!-- Main content -->
  <main class="flex-1 p-6 fade-in-up">
    @if(session('success'))
      <div class="max-w-4xl mx-auto mt-4 p-3 bg-green-100 border border-green-300 rounded shadow-lg transform transition-all duration-300 hover:scale-105">
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
