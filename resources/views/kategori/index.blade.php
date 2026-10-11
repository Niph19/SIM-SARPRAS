<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Kategori Sarana</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        @include('shared.flash')
        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex gap-2">
                <label class="sr-only" for="search">Cari kategori</label>
                <input id="search" name="search" value="{{ $search }}" placeholder="Cari kategori..." class="rounded border-gray-300">
                <button class="rounded bg-gray-800 px-4 py-2 text-white">Cari</button>
            </form>
            <a href="{{ route('kategori.create') }}" class="rounded bg-blue-700 px-4 py-2 text-white">Tambah kategori</a>
        </div>
        <div class="overflow-x-auto rounded bg-white shadow">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-100"><tr><th class="p-3">Nama kategori</th><th class="p-3">Deskripsi</th><th class="p-3">Aksi</th></tr></thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t"><td class="p-3">{{ $category->nama_kategori }}</td><td class="p-3">{{ $category->deskripsi }}</td><td class="flex gap-3 p-3">
                            <a class="text-blue-700 underline" href="{{ route('kategori.edit', $category) }}">Ubah</a>
                            <form method="POST" action="{{ route('kategori.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">@csrf @method('DELETE')<button class="text-red-700 underline">Hapus</button></form>
                        </td></tr>
                    @empty
                        <tr><td colspan="3" class="p-4 text-center text-gray-600">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $categories->links() }}
    </main>
</x-app-layout>
