<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Riwayat Laporan Saya</h2>
        <p class="text-sm text-gray-500 mt-0.5">Status laporan kerusakan yang telah kamu kirim</p>
    </x-slot>

    <main class="mx-auto max-w-7xl space-y-5 p-6">
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50">
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Sarana</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Ruangan</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Jenis Kerusakan</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Deskripsi</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Foto</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-xs text-gray-500 whitespace-nowrap">
                                    {{ $report->tanggal_laporan->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900">{{ $report->sarana->nama_sarana }}</td>
                                <td class="px-4 py-3 text-gray-600">{{ $report->ruangan->nama_ruangan }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $report->jenis_kerusakan }}</td>
                                <td class="px-4 py-3 max-w-xs">
                                    <p class="text-gray-600 text-xs truncate">{{ $report->deskripsi_kerusakan }}</p>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($report->foto)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($report->foto) }}"
                                           target="_blank" rel="noopener"
                                           class="inline-flex items-center gap-1 text-secondary hover:text-secondary-700 text-xs font-medium">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Lihat foto
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
                                        $statusIcon = match($report->status) {
                                            'pending' => '⏳',
                                            'dalam_perbaikan' => '🔧',
                                            'selesai' => '✓',
                                            'ditolak' => '✕',
                                            default => '',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-medium {{ $statusColor }}">
                                        {{ str($report->status)->replace('_', ' ')->title() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <svg class="mx-auto mb-3 h-12 w-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-500">Belum ada laporan</p>
                                        <p class="mt-1 text-xs text-gray-400">Laporkan kerusakan sarana melalui halaman utama</p>
                                    </div>
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
