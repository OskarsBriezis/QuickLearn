<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'QuickLearn')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="min-h-screen flex flex-col bg-gradient-to-b from-blue-100 via-blue-200 to-blue-300 text-gray-900">

  <!-- Navbar -->
  <header class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
      <a href="{{ route('user.dashboard') }}" class="text-2xl font-bold text-blue-600">QuickLearn</a>

      <!-- Desktop Links -->
      <nav class="hidden md:flex items-center gap-6">
        <a href="{{ route('user.history.categories') }}" class="hover:text-blue-800 font-medium transition">History</a>
        @if(auth()->check() && auth()->user()->is_admin)
          <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-800 font-medium transition">Admin</a>
        @endif
        @auth
          <span class="font-medium">{{ auth()->user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button class="hover:text-red-600 font-medium transition">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="hover:text-blue-800 font-medium transition">Login</a>
          <a href="{{ route('register') }}" class="hover:text-blue-800 font-medium transition">Register</a>
        @endauth
      </nav>

      <!-- Mobile Hamburger -->
      <div class="md:hidden">
        <button id="mobile-menu-button" class="focus:outline-none">
          <i data-feather="menu"></i>
        </button>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-2">
      @auth
        <span class="block py-1 font-medium">{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="block py-1 hover:text-red-600 font-medium">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="block py-1 hover:text-blue-800 font-medium">Login</a>
        <a href="{{ route('register') }}" class="block py-1 hover:text-blue-800 font-medium">Register</a>
      @endauth
    </div>
  </header>

  <!-- Main Content -->
  <main class="flex-grow max-w-7xl mx-auto p-4 md:p-6 space-y-6">
    @yield('content')
  </main>

  <!-- Sticky Footer -->
  <footer class="bg-white text-gray-700 text-center py-4 shadow-inner mt-auto border-t border-gray-200">
    <p class="text-sm">&copy; {{ date('Y') }} QuickLearn. All rights reserved.</p>
  </footer>

  <script>
    feather.replace();

    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    menuButton.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>
</body>
</html>
