@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Detail Berita</h1>

    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($berita->status) }}
    </div>
    <h2>{{ $berita->judul }}</h2>
    <p class="text-muted">Dibuat: {{ $berita->created_at?->format('d-m-Y H:i') ?? '-' }}</p>

    @if ($berita->gambar)
        @php $ext = strtolower(pathinfo($berita->gambar, PATHINFO_EXTENSION)); @endphp
        @if (in_array($ext, ['mp4', 'mov', 'avi'], true))
            <video controls style="max-width:100%"><source src="{{ asset('storage/' . $berita->gambar) }}"></video>
        @else
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Media berita" style="max-width:100%">
        @endif
    @endif

    <div class="mt-3">{!! nl2br(e($berita->deskripsi)) !!}</div>

    <div class="mt-4">
        <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.berita.index', ['status' => $berita->status]) }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection