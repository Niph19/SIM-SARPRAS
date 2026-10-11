<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Berita Acara {{ $record->no_berita_acara }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13px;
            line-height: 1.6;
            color: #111827;
            background: #f9fafb;
            padding: 2rem 1rem;
        }
        .container {
            max-width: 760px;
            margin: 0 auto;
            background: #fff;
            padding: 3rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 1.5rem;
            margin-bottom: 2rem;
        }
        .header h1 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .header p {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 0.25rem;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 1.5rem;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 0.35rem 0.5rem;
            vertical-align: top;
        }
        .meta-table td:first-child {
            width: 180px;
            font-weight: 600;
            color: #374151;
        }
        .keterangan-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            padding: 1rem;
            margin: 1.5rem 0;
            white-space: pre-line;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 3rem;
            padding-top: 2rem;
        }
        .signature-block {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            border-bottom: 1px solid #111827;
            height: 60px;
            margin-bottom: 0.5rem;
        }
        .print-btn {
            display: block;
            margin: 0 auto 1.5rem;
            padding: 0.5rem 1.5rem;
            background: #db2777;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
        }
        @media print {
            body { background: #fff; padding: 0; }
            .container { border: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">🖨 Cetak Dokumen / Simpan PDF</button>

    <div class="container">
        <div class="header">
            <h1>BERITA ACARA {{ str($record->jenis_tindakan)->upper() }} SARANA</h1>
            <p>SatuSarpras — Sistem Informasi Manajemen Sarana Prasarana</p>
            <p style="margin-top: 0.5rem; font-weight: 600;">Nomor: {{ $record->no_berita_acara }}</p>
        </div>

        <p style="margin-bottom: 1rem;">
            Pada hari ini, tanggal <strong>{{ $record->tanggal->translatedFormat('d F Y') }}</strong>,
            telah dilaksanakan tindakan <strong>{{ $record->jenis_tindakan }}</strong> terhadap sarana prasarana sekolah dengan rincian sebagai berikut:
        </p>

        <table class="meta-table">
            <tr><td>Kode Sarana</td><td>: <strong>{{ $record->sarana->kode_sarana }}</strong></td></tr>
            <tr><td>Nama Sarana</td><td>: {{ $record->sarana->nama_sarana }}</td></tr>
            <tr><td>Kategori</td><td>: {{ $record->sarana->kategori->nama_kategori }}</td></tr>
            <tr><td>Lokasi / Ruangan</td><td>: {{ $record->sarana->ruangan->nama_ruangan }} ({{ $record->sarana->ruangan->kode_ruangan }})</td></tr>
            <tr><td>Jenis Tindakan</td><td>: <strong style="text-transform: capitalize;">{{ $record->jenis_tindakan }}</strong></td></tr>
            <tr><td>Petugas Pelaksana</td><td>: {{ $record->pembuat->nama }}</td></tr>
        </table>

        <div style="font-weight: 600; margin-bottom: 0.5rem;">Uraian Hasil Tindakan:</div>
        <div class="keterangan-box">{{ $record->keterangan }}</div>

        <p style="font-size: 0.8rem; color: #6b7280;">
            Demikian Berita Acara ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
        </p>

        <div class="signatures">
            <div class="signature-block">
                <p style="font-size: 0.8rem; color: #6b7280;">Mengetahui,</p>
                <p style="font-weight: 600; font-size: 0.85rem;">Kepala Sarpras</p>
                <div class="signature-line"></div>
                <p style="font-size: 0.8rem; color: #9ca3af;">( .................................... )</p>
            </div>
            <div class="signature-block">
                <p style="font-size: 0.8rem; color: #6b7280;">Yang Melaksanakan,</p>
                <p style="font-weight: 600; font-size: 0.85rem;">Petugas</p>
                <div class="signature-line"></div>
                <p style="font-weight: 600; font-size: 0.85rem;">{{ $record->pembuat->nama }}</p>
            </div>
        </div>
    </div>
</body>
</html>
