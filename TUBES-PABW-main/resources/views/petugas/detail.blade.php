@extends('layouts.petugas')

@section('title', 'Detail Laporan')

@section('content')
    <a href="{{ route('petugas.laporan') }}" class="btn btn-link px-0 mb-3">Kembali ke daftar</a>
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Detail Laporan #{{ $laporan->id }}</h1>
            <span class="badge {{ $laporan->status === 'selesai' ? 'text-bg-success' : ($laporan->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ strtoupper($laporan->status) }}</span>
        </div>
        @if ($laporan->status !== 'selesai' && $laporan->status !== 'rejected')
            <form method="POST" action="{{ route('petugas.laporan.complete', $laporan) }}" onsubmit="return confirm('Tandai laporan ini selesai dan kirim BAP ke notifikasi pelapor?')">
                @csrf
                <button class="btn btn-success">Selesaikan & Buat BAP</button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @error('status')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    <section class="bg-white border rounded p-4">
        <h2 class="h5 mb-3">Data Pelapor</h2>
        <dl class="row">
            <dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $laporan->nama }}</dd>
            <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $laporan->email }}</dd>
            <dt class="col-sm-3">Nomor telepon</dt><dd class="col-sm-9">{{ $laporan->notelp }}</dd>
        </dl>
        <hr>
        <h2 class="h5 mb-3">Data Kejadian</h2>
        <dl class="row">
            <dt class="col-sm-3">Kategori</dt><dd class="col-sm-9">{{ $laporan->kategori }}</dd>
            <dt class="col-sm-3">Prioritas</dt><dd class="col-sm-9">{{ $laporan->prioritas }}</dd>
            <dt class="col-sm-3">Tanggal dan waktu</dt><dd class="col-sm-9">{{ $laporan->date }} pukul {{ $laporan->time }}</dd>
            <dt class="col-sm-3">Alamat kejadian</dt><dd class="col-sm-9">{{ $laporan->alamat }}</dd>
            <dt class="col-sm-3">Kantor tujuan</dt><dd class="col-sm-9">{{ $laporan->polres }}</dd>
            <dt class="col-sm-3">Uraian laporan</dt><dd class="col-sm-9" style="white-space:pre-wrap">{{ $laporan->deskripsi }}</dd>
        </dl>
        @if ($laporan->foto)
            <h3 class="h6">Lampiran laporan</h3>
            <a href="{{ asset('storage/' . $laporan->foto) }}" target="_blank" rel="noopener">Lihat lampiran</a>
        @endif
    </section>
@endsection