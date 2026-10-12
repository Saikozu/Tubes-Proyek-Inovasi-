@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Berita</h1>
    <div class="row">
    @foreach($beritas as $b)
        <div class="col-md-6 mb-4">
            <div class="card">
                @if($b->gambar)
                    @php $ext = pathinfo($b->gambar, PATHINFO_EXTENSION); @endphp
                    @if(in_array(strtolower($ext), ['mp4','mov','avi']))
                        <video controls style="max-width:100%"><source src="{{ asset('storage/' . $b->gambar) }}"></video>
                    @else
                        <img src="{{ asset('storage/' . $b->gambar) }}" class="card-img-top" />
                    @endif
                @endif
                <div class="card-body">
                    <h5 class="card-title"><a href="{{ route('berita.show', $b) }}">{{ $b->judul }}</a></h5>
                    <p class="card-text">{{ Str::limit($b->deskripsi, 150) }}</p>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    {{ $beritas->links() }}
</div>
@endsection
