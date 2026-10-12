@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $berita->judul }}</h1>
    @if($berita->gambar)
        @php $ext = pathinfo($berita->gambar, PATHINFO_EXTENSION); @endphp
        @if(in_array(strtolower($ext), ['mp4','mov','avi']))
            <video controls style="max-width:100%"><source src="{{ asset('storage/' . $berita->gambar) }}"></video>
        @else
            <img src="{{ asset('storage/' . $berita->gambar) }}" style="max-width:100%" />
        @endif
    @endif
    <div class="mt-3">{!! nl2br(e($berita->deskripsi)) !!}</div>

    <div class="mt-4">
        <form action="{{ route('berita.like', $berita) }}" method="POST">@csrf
            <button class="btn btn-sm btn-outline-primary">{{ $liked ? 'Unlike' : 'Like' }} ({{ $berita->likes->count() }})</button>
        </form>
    </div>

    <hr>
    <h5>Komentar</h5>
    @foreach($berita->comments as $c)
        <div><strong>{{ $c->user->name ?? 'Anon' }}</strong> - {{ $c->created_at->diffForHumans() }}</div>
        <div>{{ $c->body }}</div>
        <hr>
    @endforeach

    @auth
    <form action="{{ route('berita.comment', $berita) }}" method="POST">@csrf
        <div class="mb-3"><textarea name="body" class="form-control" rows="3"></textarea></div>
        <button class="btn btn-primary">Kirim Komentar</button>
    </form>
    @else
    <p>Silakan <a href="{{ route('login') }}">login</a> untuk komentar atau like.</p>
    @endauth
</div>
@endsection
