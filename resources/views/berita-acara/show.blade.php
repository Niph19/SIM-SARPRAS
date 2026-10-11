<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold">Berita Acara {{ $record->no_berita_acara }}</h2></x-slot>
    <main class="mx-auto max-w-3xl space-y-4 p-6">
        @include('shared.flash')
        <article class="space-y-3 rounded bg-white p-6 shadow">
            <p><strong>Nomor:</strong> {{ $record->no_berita_acara }}</p>
            <p><strong>Tanggal:</strong> {{ $record->tanggal->format('d/m/Y') }}</p>
            <p><strong>Pembuat:</strong> {{ $record->pembuat->nama }}</p>
            <p><strong>Sarana:</strong> {{ $record->sarana->kode_sarana }} — {{ $record->sarana->nama_sarana }}</p>
            <p><strong>Jenis tindakan:</strong> {{ str($record->jenis_tindakan)->title() }}</p>
            <p><strong>Keterangan:</strong><br>{{ $record->keterangan }}</p>
            <div class="flex gap-3"><a class="text-blue-700 underline" href="{{ route('berita-acara.print', $record) }}">Cetak</a><a class="text-blue-700 underline" href="{{ route('berita-acara.index') }}">Kembali</a></div>
        </article>
    </main>
</x-app-layout>
