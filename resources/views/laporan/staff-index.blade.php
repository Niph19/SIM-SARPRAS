<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Laporan Kerusakan</h2></x-slot>
    <main class="mx-auto max-w-7xl space-y-4 p-6">
        @include('shared.flash')
        <form method="GET" class="flex flex-wrap gap-2 rounded bg-white p-4 shadow">
            <label class="sr-only" for="search">Cari laporan</label><input id="search" name="search" value="{{ $search }}" placeholder="Cari sarana/pelapor/deskripsi..." class="rounded border-gray-300">
            <label class="sr-only" for="status">Status</label><select id="status" name="status" class="rounded border-gray-300"><option value="">Semua status</option>@foreach (['pending', 'dalam_perbaikan', 'selesai', 'ditolak'] as $value)<option value="{{ $value }}" @selected($status === $value)>{{ str($value)->replace('_', ' ')->title() }}</option>@endforeach</select>
            <label class="sr-only" for="id_kategori">Kategori</label><select id="id_kategori" name="id_kategori" class="rounded border-gray-300"><option value="">Semua kategori</option>@foreach ($categories as $category)<option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>{{ $category->nama_kategori }}</option>@endforeach</select>
            <button class="rounded bg-gray-800 px-4 py-2 text-white">Terapkan</button>
        </form>
        <div class="overflow-x-auto rounded bg-white shadow"><table class="w-full text-left text-sm">
            <thead class="bg-gray-100"><tr><th class="p-3">Tanggal</th><th class="p-3">Pelapor</th><th class="p-3">Sarana</th><th class="p-3">Ruangan</th><th class="p-3">Kerusakan</th><th class="p-3">Foto</th><th class="p-3">Status</th><th class="p-3">Ubah status</th></tr></thead>
            <tbody>@forelse ($reports as $report)<tr class="border-t"><td class="p-3">{{ $report->tanggal_laporan->format('d/m/Y H:i') }}</td><td class="p-3">{{ $report->murid->nama }}</td><td class="p-3">{{ $report->sarana->nama_sarana }}</td><td class="p-3">{{ $report->ruangan->nama_ruangan }}</td><td class="p-3">{{ $report->jenis_kerusakan }} — {{ $report->deskripsi_kerusakan }}</td><td class="p-3">@if ($report->foto)<a class="text-blue-700 underline" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($report->foto) }}" target="_blank" rel="noopener">Lihat</a>@else — @endif</td><td class="p-3">{{ str($report->status)->replace('_', ' ')->title() }}</td><td class="p-3">
                @if (in_array($report->status, ['pending', 'dalam_perbaikan']))
                    <form method="POST" action="{{ route('laporan.status', $report) }}" class="flex gap-2">@csrf @method('PATCH')<select name="status" aria-label="Status baru laporan {{ $report->id }}" class="rounded border-gray-300">@if ($report->status === 'pending')<option value="dalam_perbaikan">Dalam perbaikan</option>@endif<option value="ditolak">Ditolak</option>@if ($report->status === 'dalam_perbaikan')<option value="selesai">Selesai</option>@endif</select><button class="rounded bg-blue-700 px-3 py-1 text-white">Simpan</button></form>
                @endif
            </td></tr>@empty<tr><td colspan="8" class="p-4 text-center">Belum ada laporan.</td></tr>@endforelse</tbody>
        </table></div>
        {{ $reports->links() }}
    </main>
</x-app-layout>
