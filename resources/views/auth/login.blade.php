<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Masuk ke Akun</h1>
        <p class="text-sm text-gray-600">Kelola fasilitas sekolah dengan mudah</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="nama@sekolah.sch.id"
            />
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Kata Sandi</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="••••••••"
            />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"
            />
            <label for="remember_me" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <button
                type="submit"
                class="w-full bg-primary hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-2 focus:ring-primary focus:ring-offset-2"
            >
                Masuk
            </button>

            <div class="text-center space-y-3">
                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-primary hover:text-primary-700 transition-colors"
                    >
                        Lupa kata sandi?
                    </a>
                @endif

                <div class="text-sm text-gray-600">
                    Belum punya akun?
                    <a
                        href="{{ route('register') }}"
                        class="text-primary hover:text-primary-700 font-medium transition-colors"
                    >
                        Daftar sekarang
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
