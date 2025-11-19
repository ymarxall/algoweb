<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white p-8 rounded-2xl shadow-2xl max-w-md mx-auto">
        @csrf

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('algo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back</h2>
            <p class="text-gray-500 text-sm">Sign in to continue to your account</p>
        </div>

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold mb-2" />
            <x-text-input id="email" 
                class="block mt-1 w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-orange-500 focus:ring-2 transition duration-200 text-gray-800" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username" 
                placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-orange-600" />
        </div>

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold mb-2" />

            <x-text-input id="password" 
                class="block mt-1 w-full px-4 py-3 rounded-lg border-2 border-gray-200 focus:border-orange-500 focus:ring-orange-500 focus:ring-2 transition duration-200 text-gray-800"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Enter your password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-orange-600" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" 
                    type="checkbox" 
                    class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500 focus:ring-2 cursor-pointer" 
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-orange-500 hover:text-orange-600 font-semibold transition duration-200" 
                   href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="mt-6">
            <x-primary-button class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 focus:ring-4 focus:ring-orange-300">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

    
    </form>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        input::placeholder {
            color: #9ca3af;
        }
    </style>
</x-guest-layout>