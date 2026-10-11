<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Riwayat Laporan Saya</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        <div class="overflow-x-auto rounded bg-white shadow"><table class="w-full text-left text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3">Tanggal</th><th class="p-3">Sarana</th><th class="p-3">Ruangan</th><th class="p-3">Jenis</th><th class="p-3">Deskripsi</th><th class="p-3">Foto</th><th class="p-3">Status</th></tr></thead>
            <tbody>@forelse ($reports as $report)<tr class="border-t"><td class="p-3">{{ $report->tanggal_laporan->format('d/m/Y H:i') }}</td><td class="p-3">{{ $report->sarana->nama_sarana }}</td><td class="p-3">{{ $report->ruangan->nama_ruangan }}</td><td class="p-3">{{ $report->jenis_kerusakan }}</td><td class="p-3">{{ $report->deskripsi_kerusakan }}</td><td class="p-3">@if ($report->foto)<a class="text-blue-700 underline" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($report->foto) }}" target="_blank" rel="noopener">Lihat foto</a>@else — @endif</td><td class="p-3">{{ str($report->status)->replace('_', ' ')->title() }}</td></tr>@empty<tr><td colspan="7" class="p-4 text-center">Belum ada laporan.</td></tr>@endforelse</tbody>
        </table></div>
        {{ $reports->links() }}
    </main>
</x-app-layout>
