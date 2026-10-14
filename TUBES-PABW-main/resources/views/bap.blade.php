<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BAP Laporan #{{ $laporan->id }}</title>
    <style>
        body { color: #111; font: 15px/1.6 Georgia, 'Times New Roman', serif; margin: 32px auto; max-width: 850px; padding: 0 28px; }
        header { border-bottom: 2px solid #111; margin-bottom: 28px; padding-bottom: 14px; text-align: center; }
        header h1 { font-size: 20px; margin: 0; }
        header p { margin: 4px 0 0; }
        h2 { font-size: 16px; margin: 24px 0 8px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #777; padding: 8px 10px; text-align: left; vertical-align: top; }
        th { width: 30%; }
        .statement { text-align: justify; }
        .signatures { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-top: 56px; text-align: center; }
        .signature-space { height: 76px; }
        .actions { display: flex; gap: 10px; justify-content: center; margin: 24px 0; }
        .actions a, .actions button { background: #1e293b; border: 0; border-radius: 4px; color: white; cursor: pointer; padding: 9px 14px; text-decoration: none; }
        @media print { body { margin: 0; max-width: none; padding: 0; } .actions { display: none; } }
        @media (max-width: 560px) { body { padding: 0 12px; } .signatures { gap: 16px; } th, td { padding: 6px; } }
    </style>
</head>
<body>
    <div class="actions">
        <a href="{{ route('notifikasi') }}">Kembali ke notifikasi</a>
        <button type="button" onclick="window.print()">Cetak BAP</button>
    </div>
    <header>
        <h1>BERITA ACARA PEMERIKSAAN</h1>
        <p>Nomor: BAP/{{ now()->format('Y') }}/{{ str_pad((string) $laporan->id, 5, '0', STR_PAD_LEFT) }}</p>
    </header>
    <p class="statement">Berita Acara Pemeriksaan ini dibuat berdasarkan data laporan kejadian yang tersimpan dalam sistem Sahabat Warga. Data berikut merupakan uraian yang disampaikan oleh pelapor dan telah ditindaklanjuti oleh petugas.</p>

    <h2>Identitas Pelapor</h2>
    <table>
        <tr><th>Nama</th><td>{{ $laporan->nama }}</td></tr>
        <tr><th>Email</th><td>{{ $laporan->email }}</td></tr>
        <tr><th>Nomor telepon</th><td>{{ $laporan->notelp }}</td></tr>
    </table>

    <h2>Data Kejadian dan Laporan</h2>
    <table>
        <tr><th>Kategori</th><td>{{ $laporan->kategori }}</td></tr>
        <tr><th>Tanggal dan waktu kejadian</th><td>{{ $laporan->date }} pukul {{ $laporan->time }}</td></tr>
        <tr><th>Alamat kejadian</th><td>{{ $laporan->alamat }}</td></tr>
        <tr><th>Kantor tujuan</th><td>{{ $laporan->polres }}</td></tr>
        <tr><th>Uraian laporan</th><td style="white-space:pre-wrap">{{ $laporan->deskripsi }}</td></tr>
        <tr><th>Status</th><td>{{ strtoupper($laporan->status) }}</td></tr>
        <tr><th>Tanggal penyelesaian</th><td>{{ $laporan->updated_at->format('d-m-Y H:i') }}</td></tr>
    </table>

    <p class="statement">Demikian berita acara ini dibuat sesuai data laporan yang tercatat dalam sistem untuk digunakan sebagaimana mestinya.</p>
    <div class="signatures">
        <div><div>Pelapor</div><div class="signature-space"></div><strong>{{ $laporan->nama }}</strong></div>
        <div><div>Petugas</div><div class="signature-space"></div><strong>Petugas Sahabat Warga</strong></div>
    </div>
</body>
</html>