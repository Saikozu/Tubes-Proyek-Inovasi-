@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Berita</h1>
    <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <strong>Status:</strong> {{ ucfirst($berita->status) }}
        </div>
        <div class="mb-3">
            <label>Judul</label>
            <input name="judul" class="form-control" value="{{ old('judul', $berita->judul) }}">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $berita->deskripsi) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Gambar / Video (ganti)</label>
            <input type="file" name="media" class="form-control">
            @if($berita->gambar)
                <p>Media sekarang: {{ $berita->gambar }}</p>
            @endif
        </div>
        <button class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
