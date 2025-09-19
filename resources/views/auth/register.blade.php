<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-white">
        <form method="POST" action="{{ route('register') }}" class="w-full max-w-lg bg-white/90 backdrop-blur-md rounded-2xl shadow-lg p-10">
            @csrf

            <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Create an Account</h2>

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="font-semibold text-blue-700" />
                <x-text-input id="name" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="text" name="name" :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="font-semibold text-blue-700" />
                <x-text-input id="email" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="email" name="email" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="font-semibold text-blue-700" />
                <x-text-input id="password" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="font-semibold text-blue-700" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full border border-blue-200 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 bg-blue-50" type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <label for="remember_me" class="inline-flex items-center text-blue-700 text-sm">
                    <input id="remember_me" type="checkbox" class="rounded border-blue-300 text-blue-600 shadow-sm focus:ring-blue-400" name="remember">
                    <span class="ml-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between">
                @if (Route::has('login'))
                    <a class="text-sm text-blue-600 hover:text-blue-800 underline" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                @endif

                <x-primary-button class="bg-gradient-to-r from-blue-500 to-blue-700 hover:from-blue-600 hover:to-blue-800 text-white px-6 py-2 rounded-lg shadow transition">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
