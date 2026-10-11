<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">{{ $record->exists ? 'Ubah' : 'Buat' }} Berita Acara</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $record->exists ? 'Perbarui dokumen berita acara' : 'Buat dokumen resmi baru untuk tindakan sarana' }}</p>
    </x-slot>

    <main class="mx-auto max-w-2xl p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gray-50 px-6 py-4">
                <h3 class="font-medium text-gray-900 text-sm">Dokumen Berita Acara</h3>
            </div>
            <form method="POST"
                  action="{{ $record->exists ? route('berita-acara.update', $record) : route('berita-acara.store') }}"
                  class="space-y-5 p-6">
                @csrf
                @if ($record->exists) @method('PUT') @endif

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="no_berita_acara" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Nomor Berita Acara <span class="text-red-500">*</span>
                        </label>
                        <input id="no_berita_acara" name="no_berita_acara"
                               value="{{ old('no_berita_acara', $record->no_berita_acara) }}"
                               required maxlength="100" placeholder="Contoh: BA/2026/03/001"
                               class="w-full rounded-lg border-gray-300 font-mono text-sm focus:border-primary focus:ring-primary">
                        @error('no_berita_acara')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="tanggal" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input id="tanggal" name="tanggal" type="date"
                               value="{{ old('tanggal', $record->tanggal?->format('Y-m-d') ?? date('Y-m-d')) }}"
                               required
                               class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        @error('tanggal')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="id_sarana" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Sarana <span class="text-red-500">*</span>
                        </label>
                        <select id="id_sarana" name="id_sarana" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="">Pilih sarana</option>
                            @foreach ($facilities as $facility)
                                <option value="{{ $facility->id }}" @selected((string) old('id_sarana', $record->id_sarana) === (string) $facility->id)>
                                    {{ $facility->kode_sarana }} — {{ $facility->nama_sarana }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_sarana')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jenis_tindakan" class="mb-1.5 block text-sm font-medium text-gray-700">
                            Jenis Tindakan <span class="text-red-500">*</span>
                        </label>
                        <select id="jenis_tindakan" name="jenis_tindakan" required
                                class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                            <option value="">Pilih tindakan</option>
                            @foreach (['perbaikan' => 'Perbaikan', 'pemeliharaan' => 'Pemeliharaan', 'penghapusan' => 'Penghapusan'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('jenis_tindakan', $record->jenis_tindakan) === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_tindakan')
                            <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="keterangan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Keterangan / Uraian Hasil <span class="text-red-500">*</span>
                    </label>
                    <textarea id="keterangan" name="keterangan" rows="5" required
                              placeholder="Uraikan hasil pemeriksaan atau tindakan yang telah dilakukan..."
                              class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">{{ old('keterangan', $record->keterangan) }}</textarea>
                    @error('keterangan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-5 py-2.5 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan
                    </button>
                    <a href="{{ route('berita-acara.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </main>
</x-app-layout>
