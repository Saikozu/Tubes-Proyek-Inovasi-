@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Kelola Berita</h1>

    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary mb-3">
        Buat Berita
    </a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <ul class="nav nav-tabs mb-3">
        @foreach (['all' => 'Semua', 'draft' => 'Draft', 'published' => 'Published', 'takedown' => 'Takedown'] as $filter => $label)
            <li class="nav-item">
                <a class="nav-link {{ $status === $filter ? 'active' : '' }}"
                   href="{{ route('admin.berita.index', ['status' => $filter]) }}">{{ $label }}</a>
            </li>
        @endforeach
    </ul>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($beritas as $index => $berita)
                <tr>
                    <td>{{ $beritas->firstItem() + $index }}</td>
                    <td>{{ $berita->judul }}</td>
                    <td>-</td>
                    <td>{{ $berita->created_at?->format('d-m-Y H:i') ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $berita->status === 'published' ? 'bg-success' : ($berita->status === 'draft' ? 'bg-secondary' : 'bg-warning text-dark') }}">
                            {{ ucfirst($berita->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.berita.show', $berita) }}" class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.berita.edit', $berita) }}" class="btn btn-sm btn-warning">Edit</a>

                        @if ($berita->status === 'draft')
                            <form action="{{ route('admin.berita.publish', $berita) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-success" onclick="return confirm('Apakah Anda yakin ingin mempublish berita ini?')">Publish</button>
                            </form>
                        @elseif ($berita->status === 'published')
                            <form action="{{ route('admin.berita.takedown', $berita) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin melakukan takedown berita ini?')">Takedown</button>
                            </form>
                        @else
                            <form action="{{ route('admin.berita.draft', $berita) }}" method="POST" style="display:inline">
                                @csrf
                                <button class="btn btn-sm btn-secondary" onclick="return confirm('Kembalikan berita ini menjadi Draft?')">Kembalikan ke Draft</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                              method="POST"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Hapus berita?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Belum ada berita</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $beritas->links() }}
</div>
@endsection
