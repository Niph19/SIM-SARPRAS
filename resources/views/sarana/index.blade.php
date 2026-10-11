<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Data Sarana</h2>
        <p class="text-sm text-gray-500 mt-0.5">Inventaris sarana dan prasarana sekolah</p>
    </x-slot>

    <main class="mx-auto max-w-7xl space-y-5 p-6">
        @include('shared.flash')

        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="GET" class="flex flex-wrap gap-2">
                <label class="sr-only" for="search">Cari sarana</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search" name="search" value="{{ $search }}" placeholder="Cari kode/nama sarana..."
                        class="rounded-lg border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
                </div>
                <select id="id_kategori" name="id_kategori"
                        class="rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                            {{ $category->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="rounded-lg bg-gray-800 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition-colors">
                    Terapkan
                </button>
            </form>
            <a href="{{ route('sarana.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Sarana
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Kode</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Nama Sarana</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Ruangan</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Kondisi</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Jml</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($facilities as $facility)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="inline-block rounded bg-gray-100 px-2 py-0.5 font-mono text-xs font-medium text-gray-700">
                                        {{ $facility->kode_sarana }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $facility->nama_sarana }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $facility->kategori->nama_kategori }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $facility->ruangan->nama_ruangan }}</td>
                                <td class="px-4 py-3">
                                    @php
                                        $kondisiColor = match($facility->kondisi) {
                                            'baik' => 'bg-green-100 text-green-700',
                                            'rusak_ringan' => 'bg-yellow-100 text-yellow-700',
                                            'rusak_berat' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $kondisiColor }}">
                                        {{ str($facility->kondisi)->replace('_', ' ')->title() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColor = $facility->status_perbaikan === 'dalam_perbaikan'
                                            ? 'bg-amber-100 text-amber-700'
                                            : 'bg-gray-100 text-gray-700';
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $statusColor }}">
                                        {{ str($facility->status_perbaikan)->replace('_', ' ')->title() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">{{ $facility->jumlah }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('sarana.edit', $facility) }}"
                                           class="inline-flex items-center gap-1 text-secondary hover:text-secondary-700 text-xs font-medium transition-colors">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('sarana.destroy', $facility) }}"
                                              onsubmit="return confirm('Hapus sarana ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-xs font-medium transition-colors">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                                    <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    Belum ada sarana.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>{{ $facilities->links() }}</div>
    </main>
</x-app-layout>
