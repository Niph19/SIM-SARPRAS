<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h1>
        <p class="text-sm text-gray-600">Buat akun murid untuk melaporkan kerusakan fasilitas</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
            <input
                id="nama"
                type="text"
                name="nama"
                value="{{ old('nama') }}"
                required
                autofocus
                autocomplete="name"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="Masukkan nama lengkap"
            />
            @error('nama')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autocomplete="username"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="nama@siswa.sekolah.sch.id"
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
                autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="Minimal 8 karakter"
            />
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 font-mono text-sm"
                placeholder="Ulangi kata sandi"
            />
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Notice -->
        <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-800">
                        Akun yang didaftarkan otomatis memiliki role <strong>murid</strong>.
                        Anda dapat melaporkan kerusakan fasilitas dan memantau status laporan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="space-y-4">
            <button
                type="submit"
                class="w-full bg-primary hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-md transition-all duration-200 focus:ring-2 focus:ring-primary focus:ring-offset-2"
            >
                Daftar Sekarang
            </button>

            <div class="text-center">
                <div class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a
                        href="{{ route('login') }}"
                        class="text-primary hover:text-primary-700 font-medium transition-colors"
                    >
                        Masuk di sini
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
