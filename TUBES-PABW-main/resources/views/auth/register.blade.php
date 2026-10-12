<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label value="Nama" />
            <x-text-input
                type="text"
                name="name"
                :value="old('name')"
                required autofocus
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label value="Email" />
            <x-text-input
                type="email"
                name="email"
                :value="old('email')"
                required
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label value="Nomor Telepon" />
            <x-text-input
                type="tel"
                name="notelp"
                :value="old('notelp')"
                required
                pattern="\+?[0-9]{10,15}"
                title="Masukkan 10-15 digit, dengan tanda + di awal jika diperlukan."
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
            <x-input-error :messages="$errors->get('notelp')" />
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

        <!-- Confirm -->
        <div>
            <x-input-label value="Konfirmasi Password" />
            <x-text-input
                type="password"
                name="password_confirmation"
                required
                class="mt-1 w-full rounded-xl focus:ring-purple-500 focus:border-purple-500"
            />
        </div>

        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700
                   text-white font-semibold py-2.5 rounded-xl transition">
            Register
        </button>

        <p class="text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-purple-600 font-semibold hover:underline">
                Login
            </a>
        </p>
    </form>
</x-guest-layout>
