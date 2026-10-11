<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">{{ $room->exists ? 'Ubah' : 'Tambah' }} Ruangan</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $room->exists ? 'Perbarui data ruangan' : 'Tambahkan ruangan baru' }}</p>
    </x-slot>

    <main class="mx-auto max-w-2xl p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="font-medium text-gray-900 text-sm">Informasi Ruangan</h3>
            </div>
            <form method="POST"
                  action="{{ $room->exists ? route('ruangan.update', $room) : route('ruangan.store') }}"
                  class="space-y-5 p-6">
                @csrf
                @if ($room->exists) @method('PUT') @endif

                <div>
                    <label for="kode_ruangan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Kode Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input id="kode_ruangan" name="kode_ruangan"
                           value="{{ old('kode_ruangan', $room->kode_ruangan) }}"
                           required placeholder="Contoh: LAB-RPL-01"
                           class="w-full rounded-lg border-gray-300 font-mono text-sm focus:border-primary focus:ring-primary">
                    @error('kode_ruangan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_ruangan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input id="nama_ruangan" name="nama_ruangan"
                           value="{{ old('nama_ruangan', $room->nama_ruangan) }}"
                           required placeholder="Contoh: Lab Komputer 1"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('nama_ruangan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lokasi" class="mb-1.5 block text-sm font-medium text-gray-700">Lokasi</label>
                    <input id="lokasi" name="lokasi"
                           value="{{ old('lokasi', $room->lokasi) }}"
                           placeholder="Contoh: Gedung A, Lantai 2"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('lokasi')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($errors->has('ruangan'))
                    <p class="text-sm text-red-600">{{ $errors->first('ruangan') }}</p>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('ruangan.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
