<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Laporan Kerusakan Sarana</h2>
        <p class="text-sm text-gray-500 mt-0.5">Temukan kerusakan? Laporkan agar segera ditangani</p>
    </x-slot>

    <main class="mx-auto max-w-2xl space-y-5 p-6">
        @include('shared.flash')

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gradient-to-r from-primary-50 to-secondary-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary text-white">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-medium text-gray-900 text-sm">Form Laporan Baru</h3>
                        <p class="text-xs text-gray-500">Isi dengan lengkap agar petugas dapat menindaklanjuti</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data" class="space-y-5 p-6">
                @csrf

                <div>
                    <label for="id_ruangan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Ruangan <span class="text-red-500">*</span>
                    </label>
                    <select id="id_ruangan" name="id_ruangan" required
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                        <option value="">Pilih ruangan tempat kerusakan</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" @selected((string) old('id_ruangan') === (string) $room->id)>
                                {{ $room->kode_ruangan }} — {{ $room->nama_ruangan }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_ruangan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="id_sarana" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Sarana <span class="text-red-500">*</span>
                    </label>
                    <select id="id_sarana" name="id_sarana" required disabled
                            class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary disabled:bg-gray-50 disabled:text-gray-400">
                        <option value="">Pilih ruangan terlebih dahulu</option>
                        @foreach ($facilities as $facility)
                            <option value="{{ $facility->id }}" data-room="{{ $facility->id_ruangan }}"
                                    @selected((string) old('id_sarana') === (string) $facility->id)>
                                {{ $facility->nama_sarana }} ({{ $facility->kode_sarana }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_sarana')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kerusakan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Jenis Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <input id="jenis_kerusakan" name="jenis_kerusakan"
                           value="{{ old('jenis_kerusakan') }}"
                           required maxlength="100"
                           placeholder="Contoh: Layar retak, Kursi patah, AC rusak"
                           class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    @error('jenis_kerusakan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="deskripsi_kerusakan" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Deskripsi Kerusakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" required
                              placeholder="Jelaskan kondisi kerusakan secara detail..."
                              class="w-full rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">{{ old('deskripsi_kerusakan') }}</textarea>
                    @error('deskripsi_kerusakan')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="foto" class="mb-1.5 block text-sm font-medium text-gray-700">
                        Foto Bukti
                        <span class="text-xs font-normal text-gray-500">(opsional, maks. 5 MB)</span>
                    </label>
                    <div class="rounded-lg border-2 border-dashed border-gray-200 p-4 text-center hover:border-primary transition-colors">
                        <svg class="mx-auto mb-2 h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <input id="foto" name="foto" type="file" accept="image/*"
                               class="text-sm text-gray-600">
                        <p class="mt-1 text-xs text-gray-400">JPG, PNG, WEBP</p>
                    </div>
                    @error('foto')
                        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-5 py-3 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-2 text-sm font-medium text-gray-700 mb-3">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Cara kerja laporan
            </div>
            <div class="grid gap-3 sm:grid-cols-3 text-center">
                @foreach ([['Kirim Laporan', 'Isi form dan submit', 'bg-primary-50 text-primary'], ['Ditindaklanjuti', 'Petugas memproses', 'bg-yellow-50 text-yellow-700'], ['Selesai', 'Sarana diperbaiki', 'bg-green-50 text-green-700']] as $i => [$step, $desc, $color])
                    <div class="rounded-lg {{ $color }} p-3">
                        <div class="text-xs font-semibold uppercase tracking-wider">{{ $i + 1 }}. {{ $step }}</div>
                        <div class="mt-1 text-xs opacity-75">{{ $desc }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <script>
        const room = document.getElementById('id_ruangan');
        const facility = document.getElementById('id_sarana');
        const selectedFacility = @js(old('id_sarana'));
        function filterFacilities() {
            facility.disabled = !room.value;
            facility.value = '';
            for (const option of facility.options) {
                if (!option.value) continue;
                option.hidden = option.dataset.room !== room.value;
                if (option.value === selectedFacility && !option.hidden) facility.value = selectedFacility;
            }
        }
        room.addEventListener('change', filterFacilities);
        filterFacilities();
    </script>
</x-app-layout>
