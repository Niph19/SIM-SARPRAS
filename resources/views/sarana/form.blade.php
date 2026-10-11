<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">{{ $facility->exists ? 'Ubah' : 'Tambah' }} Sarana</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $facility->exists ? 'Perbarui data sarana' : 'Daftarkan sarana baru ke inventaris' }}</p>
    </x-slot>

    <main class="mx-auto max-w-2xl p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="font-medium text-gray-900 text-sm">Informasi Sarana</h3>
            </div>
            <form method="POST"
                  action="{{ $facility->exists ? route('sarana.update', $facility) : route('sarana.store') }}"
                  class="space-y-5 p-6">
                @csrf
                @if ($facility->exists) @method('PUT') @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="kode_sarana" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Kode Sarana <span class="text-red-500">*</span>
                        </label>
                        <input id="kode_sarana" name="kode_sarana"
                               value="{{ old('kode_sarana', $facility->kode_sarana) }}"
                               required maxlength="50" placeholder="Contoh: ELK-001"
                               class="w-full rounded-lg border-gray-300 font-mono text-sm focus:border-primary focus:ring-primary">
                        @error('kode_sarana')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input id="jumlah" name="jumlah" type="number" min="1"
                               value="{{ old('jumlah', $facility->jumlah ?? 1) }}"
                               required
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        @error('jumlah')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="nama_sarana" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Nama Sarana <span class="text-red-500">*</span>
                    </label>
                    <input id="nama_sarana" name="nama_sarana"
                           value="{{ old('nama_sarana', $facility->nama_sarana) }}"
                           required maxlength="150" placeholder="Nama lengkap sarana"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('nama_sarana')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="id_kategori" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select id="id_kategori" name="id_kategori" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('id_kategori', $facility->id_kategori) === (string) $category->id)>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="id_ruangan" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Ruangan <span class="text-red-500">*</span>
                        </label>
                        <select id="id_ruangan" name="id_ruangan" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="">Pilih ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected((string) old('id_ruangan', $facility->id_ruangan) === (string) $room->id)>
                                    {{ $room->kode_ruangan }} — {{ $room->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_ruangan')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="kondisi" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Kondisi <span class="text-red-500">*</span>
                        </label>
                        <select id="kondisi" name="kondisi" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            @foreach (['baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('kondisi', $facility->kondisi) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('kondisi')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status_perbaikan" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Status Perbaikan <span class="text-red-500">*</span>
                        </label>
                        <select id="status_perbaikan" name="status_perbaikan" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="normal" @selected(old('status_perbaikan', $facility->status_perbaikan) === 'normal')>Normal</option>
                            <option value="dalam_perbaikan" @selected(old('status_perbaikan', $facility->status_perbaikan) === 'dalam_perbaikan')>Dalam Perbaikan</option>
                        </select>
                        @error('status_perbaikan')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @if ($errors->has('sarana'))
                    <p class="text-sm text-red-600">{{ $errors->first('sarana') }}</p>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('sarana.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
