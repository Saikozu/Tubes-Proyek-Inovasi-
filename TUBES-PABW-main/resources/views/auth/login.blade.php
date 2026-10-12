<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label value="Email" />
            <x-text-input
                type="email"
                name="email"
                :value="old('email')"
                required autofocus
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label value="Password" />
            <x-text-input
                type="password"
                name="password"
                required
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center gap-2 text-gray-600">
                <input type="checkbox" name="remember"
                       class="rounded text-purple-600 focus:ring-purple-500">
                Remember me
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-purple-600 hover:underline">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700
                   text-white font-semibold py-2.5 rounded-xl transition">
            Log in
        </button>

        <p class="text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:underline">
                Register
            </a>
        </p>
    </form>
</x-guest-layout>
