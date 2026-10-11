<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Acara {{ $record->no_berita_acara }}</title>
    <style>
        body{font:16px/1.6 Arial,sans-serif;margin:2rem auto;max-width:800px;padding:0 1rem;color:#111}
        h1{text-align:center;font-size:1.4rem}dl{display:grid;grid-template-columns:170px 1fr;gap:.5rem}dt{font-weight:bold}
        @media print{.no-print{display:none}body{margin:0 auto}}
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <h1>BERITA ACARA {{ str($record->jenis_tindakan)->upper() }}</h1>
    <p>Nomor: {{ $record->no_berita_acara }}</p>
    <p>Pada tanggal {{ $record->tanggal->translatedFormat('d F Y') }}, telah dilakukan {{ $record->jenis_tindakan }} sarana berikut:</p>
    <dl>
        <dt>Kode sarana</dt><dd>{{ $record->sarana->kode_sarana }}</dd>
        <dt>Nama sarana</dt><dd>{{ $record->sarana->nama_sarana }}</dd>
        <dt>Kategori</dt><dd>{{ $record->sarana->kategori->nama_kategori }}</dd>
        <dt>Ruangan</dt><dd>{{ $record->sarana->ruangan->nama_ruangan }}</dd>
        <dt>Keterangan</dt><dd>{{ $record->keterangan }}</dd>
        <dt>Pembuat</dt><dd>{{ $record->pembuat->nama }}</dd>
    </dl>
</body>
</html>
