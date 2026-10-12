@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Buat Draft Berita</h1>
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input name="judul" class="form-control" value="{{ old('judul') }}">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Gambar / Video</label>
            <input type="file" name="media" class="form-control">
        </div>
        <button class="btn btn-primary">Simpan Draft</button>
    </form>
</div>
@endsection
