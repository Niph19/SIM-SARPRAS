<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">{{ $room->exists ? 'Ubah' : 'Tambah' }} ruangan</h2></x-slot>
    <main class="mx-auto max-w-2xl p-6"><form method="POST" action="{{ $room->exists ? route('ruangan.update', $room) : route('ruangan.store') }}" class="space-y-4 rounded bg-white p-6 shadow">
        @csrf @if ($room->exists) @method('PUT') @endif
        @foreach (['kode_ruangan' => 'Kode ruangan', 'nama_ruangan' => 'Nama ruangan', 'lokasi' => 'Lokasi'] as $field => $label)
            <div><label for="{{ $field }}" class="block">{{ $label }}</label><input id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $room->$field) }}" @required($field !== 'lokasi') class="mt-1 w-full rounded border-gray-300">@error($field)<p class="text-red-700">{{ $message }}</p>@enderror</div>
        @endforeach
        @if ($errors->has('ruangan'))<p class="text-red-700">{{ $errors->first('ruangan') }}</p>@endif
        <div class="flex gap-3"><button class="rounded bg-blue-700 px-4 py-2 text-white">Simpan</button><a href="{{ route('ruangan.index') }}" class="rounded border px-4 py-2">Batal</a></div>
    </form></main>
</x-app-layout>
