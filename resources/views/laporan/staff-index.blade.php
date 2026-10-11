<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Laporan Kerusakan</h2>
        <p class="text-sm text-gray-500 mt-0.5">Kelola semua laporan kerusakan sarana dari murid</p>
    </x-slot>

    <main class="mx-auto max-w-7xl space-y-5 p-6">
        @include('shared.flash')

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
            <form method="GET" class="flex flex-wrap gap-3">
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="search" name="search" value="{{ $search }}" placeholder="Cari sarana/pelapor/deskripsi..."
                        class="rounded-lg border-gray-300 pl-9 text-sm focus:border-primary focus:ring-primary">
                </div>
                <select id="status" name="status"
                        class="rounded-lg border-gray-300 text-sm focus:border-primary focus:ring-primary">
                    <option value="">Semua status</option>
                    @foreach (['pending', 'dalam_perbaikan', 'selesai', 'ditolak'] as $value)
                        <option value="{{ $value }}" @selected($status === $value)>
                            {{ str($value)->replace('_', ' ')->title() }}
                        </option>
                    @endforeach
                </select>
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
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Pelapor</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Sarana</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Ruangan</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Kerusakan</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Foto</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Ubah Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                    {{ $report->tanggal_laporan->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 text-xs font-semibold">
                                            {{ strtoupper(substr($report->murid->nama, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-gray-900">{{ $report->murid->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $report->sarana->nama_sarana }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $report->ruangan->nama_ruangan }}</td>
                                <td class="px-4 py-3 max-w-xs">
                                    <p class="font-medium text-gray-800 text-xs">{{ $report->jenis_kerusakan }}</p>
                                    <p class="text-gray-500 text-xs truncate">{{ $report->deskripsi_kerusakan }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($report->foto)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($report->foto) }}"
                                           target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1 text-secondary hover:text-secondary-700 text-xs font-medium">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $statusColor = match($report->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'dalam_perbaikan' => 'bg-blue-100 text-blue-700',
                                            'selesai' => 'bg-green-100 text-green-700',
                                            'ditolak' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium {{ $statusColor }}">
                                        {{ str($report->status)->replace('_', ' ')->title() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if (in_array($report->status, ['pending', 'dalam_perbaikan']))
                                        <form method="POST" action="{{ route('laporan.status', $report) }}" class="flex gap-2">
                                            @csrf @method('PATCH')
                                            <select name="status" aria-label="Status baru laporan {{ $report->id }}"
                                                    class="rounded-md border-gray-300 text-xs focus:border-primary focus:ring-primary">
                                                @if ($report->status === 'pending')
                                                    <option value="dalam_perbaikan">Dalam Perbaikan</option>
                                                @endif
                                                <option value="ditolak">Ditolak</option>
                                                @if ($report->status === 'dalam_perbaikan')
                                                    <option value="selesai">Selesai</option>
                                                @endif
                                            </select>
                                            <button type="submit"
                                                    class="rounded-md bg-secondary px-3 py-1 text-xs font-medium text-white hover:bg-secondary-700 transition-colors">
                                                Simpan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-gray-500">
                                    <svg class="mx-auto mb-3 h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Belum ada laporan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>{{ $reports->links() }}</div>
    </main>
</x-app-layout>
