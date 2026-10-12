@extends('layouts.admin')

@section('content')
<h3>Feedback Pengguna</h3>

<table class="table">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Masukan</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($feedbacks as $f)
        <tr>
            <td>{{ $f->nama }}</td>
            <td>{{ $f->email }}</td>
            <td>{{ $f->notelp }}</td>
            <td>{{ $f->deskripsi }}</td>
            <td>{{ $f->created_at->format('d-m-Y H:i') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
