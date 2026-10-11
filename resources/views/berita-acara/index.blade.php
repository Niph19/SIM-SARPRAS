<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Berita Acara</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        @include('shared.flash')
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex flex-wrap gap-2">
                <label class="sr-only" for="search">Cari berita acara</label><input id="search" name="search" value="{{ $search }}" placeholder="Cari nomor/sarana/keterangan..." class="rounded border-gray-300">
                <label class="sr-only" for="id_kategori">Kategori</label><select id="id_kategori" name="id_kategori" class="rounded border-gray-300"><option value="">Semua kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->nama_kategori }}</option>@endforeach</select>
                <button class="rounded bg-gray-800 px-4 py-2 text-white">Terapkan</button>
            </form>
            <a href="{{ route('berita-acara.create') }}" class="rounded bg-blue-700 px-4 py-2 text-white">Buat berita acara</a>
        </div>
        <div class="overflow-x-auto rounded bg-white shadow"><table class="w-full text-left text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3">Nomor</th><th class="p-3">Tanggal</th><th class="p-3">Pembuat</th><th class="p-3">Sarana</th><th class="p-3">Tindakan</th><th class="p-3">Aksi</th></tr></thead>
            <tbody>@forelse ($records as $record)<tr class="border-t"><td class="p-3">{{ $record->no_berita_acara }}</td><td class="p-3">{{ $record->tanggal->format('d/m/Y') }}</td><td class="p-3">{{ $record->pembuat->nama }}</td><td class="p-3">{{ $record->sarana->nama_sarana }}</td><td class="p-3">{{ str($record->jenis_tindakan)->title() }}</td><td class="flex flex-wrap gap-3 p-3"><a class="text-blue-700 underline" href="{{ route('berita-acara.show', $record) }}">Lihat</a><a class="text-blue-700 underline" href="{{ route('berita-acara.print', $record) }}">Cetak</a>@if (in_array(auth()->user()->role, ['admin', 'petugas_sarpras']))<a class="text-blue-700 underline" href="{{ route('berita-acara.edit', $record) }}">Ubah</a><form method="POST" action="{{ route('berita-acara.destroy', $record) }}" onsubmit="return confirm('Hapus berita acara ini?')">@csrf @method('DELETE')<button class="text-red-700 underline">Hapus</button></form>@endif</td></tr>@empty<tr><td colspan="6" class="p-4 text-center">Belum ada berita acara.</td></tr>@endforelse</tbody>
        </table></div>
        {{ $records->links() }}
    </main>
</x-app-layout>
