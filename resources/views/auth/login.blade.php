<x-guest-layout>
    <div class="flex items-center justify-center bg-gradient-to-br from-blue-50 to-white">
        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-10">
            @csrf

            <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Sign In to QuickLearn</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="font-semibold text-blue-700" />
                <x-text-input id="email" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="font-semibold text-blue-700" />
                <x-text-input id="password" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <label for="remember_me" class="inline-flex items-center text-blue-700 text-sm">
                    <input id="remember_me" type="checkbox" class="rounded border-blue-300 text-blue-600 shadow-sm focus:ring-blue-400" name="remember">
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div>
                <div class="mb-4 text-sm text-blue-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="underline font-medium hover:text-blue-800 transition">Sign up</a>
            </div>

                <x-primary-button class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-2 rounded-lg shadow transition">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
