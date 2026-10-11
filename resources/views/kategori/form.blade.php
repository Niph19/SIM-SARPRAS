<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">{{ $category->exists ? 'Ubah' : 'Tambah' }} Kategori</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $category->exists ? 'Perbarui data kategori sarana' : 'Tambahkan kategori sarana baru' }}</p>
    </x-slot>

    <main class="mx-auto max-w-2xl p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="font-medium text-gray-900 text-sm">Informasi Kategori</h3>
            </div>
            <form method="POST"
                  action="{{ $category->exists ? route('kategori.update', $category) : route('kategori.store') }}"
                  class="space-y-5 p-6">
                @csrf
                @if ($category->exists) @method('PUT') @endif

                <div>
                    <label for="nama_kategori" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input id="nama_kategori" name="nama_kategori"
                           value="{{ old('nama_kategori', $category->nama_kategori) }}"
                           required maxlength="100" placeholder="Contoh: Elektronik, Meubel"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('nama_kategori')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi" class="mb-1.5 block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                              placeholder="Deskripsi singkat tentang kategori ini..."
                              class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if ($errors->has('kategori'))
                    <p class="text-sm text-red-600">{{ $errors->first('kategori') }}</p>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('kategori.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
