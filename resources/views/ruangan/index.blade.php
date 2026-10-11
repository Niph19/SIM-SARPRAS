<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Data Ruangan</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        @include('shared.flash')
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex flex-wrap gap-2">
                <label class="sr-only" for="search">Cari ruangan</label><input id="search" name="search" value="{{ $search }}" placeholder="Cari kode/nama/lokasi..." class="rounded border-gray-300">
                <label class="sr-only" for="id_kategori">Filter kategori sarana</label><select id="id_kategori" name="id_kategori" class="rounded border-gray-300"><option value="">Semua kategori sarana</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->nama_kategori }}</option>@endforeach</select>
                <button class="rounded bg-gray-800 px-4 py-2 text-white">Terapkan</button>
            </form>
            <a href="{{ route('ruangan.create') }}" class="rounded bg-blue-700 px-4 py-2 text-white">Tambah ruangan</a>
        </div>
        <div class="overflow-x-auto rounded bg-white shadow"><table class="w-full text-left text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3">Kode</th><th class="p-3">Nama</th><th class="p-3">Lokasi</th><th class="p-3">Jumlah sarana</th><th class="p-3">Aksi</th></tr></thead>
            <tbody>@forelse ($rooms as $room)<tr class="border-t"><td class="p-3">{{ $room->kode_ruangan }}</td><td class="p-3">{{ $room->nama_ruangan }}</td><td class="p-3">{{ $room->lokasi }}</td><td class="p-3">{{ $room->saranas_count }}</td><td class="flex gap-3 p-3"><a class="text-blue-700 underline" href="{{ route('ruangan.edit', $room) }}">Ubah</a><form method="POST" action="{{ route('ruangan.destroy', $room) }}" onsubmit="return confirm('Hapus ruangan ini?')">@csrf @method('DELETE')<button class="text-red-700 underline">Hapus</button></form></td></tr>@empty<tr><td colspan="5" class="p-4 text-center">Belum ada ruangan.</td></tr>@endforelse</tbody>
        </table></div>
        {{ $rooms->links() }}
    </main>
</x-app-layout>
