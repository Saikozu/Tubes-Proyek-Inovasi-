@extends('layouts.petugas')

@section('title', 'Laporan Tersedia')

@section('content')
    <h1 class="h3 mb-4">Laporan Tersedia</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive bg-white rounded border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Tanggal Kejadian</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->date }} {{ $item->time }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td><span class="badge {{ $item->status === 'selesai' ? 'text-bg-success' : ($item->status === 'rejected' ? 'text-bg-danger' : 'text-bg-warning') }}">{{ strtoupper($item->status) }}</span></td>
                        <td class="text-end"><a class="btn btn-sm btn-primary" href="{{ route('petugas.laporan.show', $item) }}">Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">Belum ada laporan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection