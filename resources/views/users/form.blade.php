<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">{{ $staff->exists ? 'Ubah' : 'Tambah' }} Akun {{ $roleTitle }}</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $staff->exists ? 'Perbarui data akun' : 'Buat akun baru untuk ' . strtolower($roleTitle) }}</p>
    </x-slot>

    <main class="mx-auto max-w-lg p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="font-medium text-gray-900 text-sm">Informasi Akun</h3>
            </div>
            <form method="POST"
                  action="{{ $staff->exists ? route($routePrefix.'.update', $staff) : route($routePrefix.'.store') }}"
                  class="space-y-5 p-6">
                @csrf
                @if ($staff->exists) @method('PUT') @endif

                <div>
                    <label for="nama" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input id="nama" name="nama"
                           value="{{ old('nama', $staff->nama) }}"
                           required maxlength="100" placeholder="Nama lengkap"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('nama')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $staff->email) }}"
                           required maxlength="100" placeholder="nama@sekolah.sch.id"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Password
                        @if ($staff->exists)
                            <span class="text-xs font-normal text-gray-500">(kosongkan jika tidak diubah)</span>
                        @else
                            <span class="text-red-500">*</span>
                        @endif
                    </label>
                    <input id="password" name="password" type="password"
                           @required(!$staff->exists) autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Konfirmasi Password
                        @if (!$staff->exists) <span class="text-red-500">*</span> @endif
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           @required(!$staff->exists) autocomplete="new-password"
                           placeholder="••••••••"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route($routePrefix.'.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
