@extends('layouts.admin')

@section('content')
<h2>Feedback Pengguna</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Isi Feedback</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($feedbacks as $i => $f)
        <tr>
            <td>{{ $i + 1 }}</td>
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
