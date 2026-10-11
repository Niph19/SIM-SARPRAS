<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Laporan Kerusakan Sarana</h2></x-slot>
    <main class="mx-auto max-w-2xl space-y-4 p-6">
        @include('shared.flash')
        <form method="POST" action="{{ route('laporan.store') }}" enctype="multipart/form-data" class="space-y-4 rounded bg-white p-6 shadow">
            @csrf
            <div><label for="id_ruangan" class="block">Ruangan</label><select id="id_ruangan" name="id_ruangan" required class="mt-1 w-full rounded border-gray-300"><option value="">Pilih ruangan</option>@foreach ($rooms as $room)<option value="{{ $room->id }}" @selected((string) old('id_ruangan') === (string) $room->id)>{{ $room->kode_ruangan }} — {{ $room->nama_ruangan }}</option>@endforeach</select>@error('id_ruangan')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <div><label for="id_sarana" class="block">Sarana</label><select id="id_sarana" name="id_sarana" required disabled class="mt-1 w-full rounded border-gray-300"><option value="">Pilih ruangan terlebih dahulu</option>@foreach ($facilities as $facility)<option value="{{ $facility->id }}" data-room="{{ $facility->id_ruangan }}" @selected((string) old('id_sarana') === (string) $facility->id)>{{ $facility->nama_sarana }} ({{ $facility->kode_sarana }})</option>@endforeach</select>@error('id_sarana')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <div><label for="jenis_kerusakan" class="block">Jenis kerusakan</label><input id="jenis_kerusakan" name="jenis_kerusakan" value="{{ old('jenis_kerusakan') }}" required maxlength="100" class="mt-1 w-full rounded border-gray-300">@error('jenis_kerusakan')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <div><label for="deskripsi_kerusakan" class="block">Deskripsi kerusakan</label><textarea id="deskripsi_kerusakan" name="deskripsi_kerusakan" rows="4" required class="mt-1 w-full rounded border-gray-300">{{ old('deskripsi_kerusakan') }}</textarea>@error('deskripsi_kerusakan')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <div><label for="foto" class="block">Foto (opsional, maksimal 5 MB)</label><input id="foto" name="foto" type="file" accept="image/*" class="mt-1 w-full rounded border-gray-300">@error('foto')<p class="text-red-700">{{ $message }}</p>@enderror</div>
            <button class="rounded bg-blue-700 px-4 py-2 text-white">Kirim laporan</button>
        </form>
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
