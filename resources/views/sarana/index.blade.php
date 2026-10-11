<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Data Sarana</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        @include('shared.flash')
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex flex-wrap gap-2">
                <label class="sr-only" for="search">Cari sarana</label><input id="search" name="search" value="{{ $search }}" placeholder="Cari kode/nama sarana..." class="rounded border-gray-300">
                <label class="sr-only" for="id_kategori">Kategori</label><select id="id_kategori" name="id_kategori" class="rounded border-gray-300"><option value="">Semua kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->nama_kategori }}</option>@endforeach</select>
                <button class="rounded bg-gray-800 px-4 py-2 text-white">Terapkan</button>
            </form>
            <a href="{{ route('sarana.create') }}" class="rounded bg-blue-700 px-4 py-2 text-white">Tambah sarana</a>
        </div>
        <div class="overflow-x-auto rounded bg-white shadow"><table class="w-full text-left text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3">Kode</th><th class="p-3">Nama</th><th class="p-3">Kategori</th><th class="p-3">Ruangan</th><th class="p-3">Kondisi</th><th class="p-3">Perbaikan</th><th class="p-3">Jumlah</th><th class="p-3">Aksi</th></tr></thead>
            <tbody>@forelse ($facilities as $facility)<tr class="border-t"><td class="p-3">{{ $facility->kode_sarana }}</td><td class="p-3">{{ $facility->nama_sarana }}</td><td class="p-3">{{ $facility->kategori->nama_kategori }}</td><td class="p-3">{{ $facility->ruangan->nama_ruangan }}</td><td class="p-3">{{ str($facility->kondisi)->replace('_', ' ')->title() }}</td><td class="p-3">{{ str($facility->status_perbaikan)->replace('_', ' ')->title() }}</td><td class="p-3">{{ $facility->jumlah }}</td><td class="flex gap-3 p-3"><a class="text-blue-700 underline" href="{{ route('sarana.edit', $facility) }}">Ubah</a><form method="POST" action="{{ route('sarana.destroy', $facility) }}" onsubmit="return confirm('Hapus sarana ini?')">@csrf @method('DELETE')<button class="text-red-700 underline">Hapus</button></form></td></tr>@empty<tr><td colspan="8" class="p-4 text-center">Belum ada sarana.</td></tr>@endforelse</tbody>
        </table></div>
        {{ $facilities->links() }}
    </main>
</x-app-layout>
