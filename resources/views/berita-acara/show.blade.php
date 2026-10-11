<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-gray-900">Detail Berita Acara</h2>
        <p class="text-sm text-gray-500 mt-0.5">{{ $record->no_berita_acara }}</p>
    </x-slot>

    <main class="mx-auto max-w-3xl space-y-5 p-6">
        @include('shared.flash')

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-gradient-to-r from-primary-50 to-secondary-50 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-mono text-xs font-semibold uppercase tracking-wider text-primary">Dokumen Resmi</span>
                        <h3 class="mt-1 text-xl font-bold text-gray-900">{{ $record->no_berita_acara }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Dibuat pada {{ $record->tanggal->translatedFormat('d F Y') }}</p>
                    </div>
                    @php
                        $tindakanBadge = match($record->jenis_tindakan) {
                            'perbaikan' => 'bg-blue-100 text-blue-800 border-blue-200',
                            'pemeliharaan' => 'bg-green-100 text-green-800 border-green-200',
                            'penghapusan' => 'bg-red-100 text-red-800 border-red-200',
                            default => 'bg-gray-100 text-gray-800 border-gray-200',
                        };
                    @endphp
                    <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold {{ $tindakanBadge }}">
                        {{ str($record->jenis_tindakan)->title() }}
                    </span>
                </div>
            </div>

            <div class="divide-y divide-gray-100 p-6 space-y-4">
                <div class="grid gap-4 sm:grid-cols-2 pt-0">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">Pembuat Dokumen</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $record->pembuat->nama }}</p>
                        <p class="text-xs text-gray-500">{{ $record->pembuat->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-400">Tanggal Pelaksanaan</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $record->tanggal->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-2">Informasi Sarana</p>
                    <div class="rounded-lg bg-gray-50 p-4">
                        <div class="grid gap-3 sm:grid-cols-3">
                            <div>
                                <p class="text-xs text-gray-500">Kode Sarana</p>
                                <p class="font-mono text-sm font-semibold text-gray-900">{{ $record->sarana->kode_sarana }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Nama Sarana</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $record->sarana->nama_sarana }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Ruangan</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $record->sarana->ruangan->nama_ruangan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400 mb-2">Keterangan / Hasil Pemeriksaan</p>
                    <div class="rounded-lg bg-gray-50 p-4">
                        <p class="text-sm text-gray-800 leading-relaxed whitespace-pre-line">{{ $record->keterangan }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4">
                <a href="{{ route('berita-acara.print', $record) }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-white hover:bg-secondary-700 transition-colors">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Dokumen
                </a>
                <a href="{{ route('berita-acara.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </main>
</x-app-layout>
