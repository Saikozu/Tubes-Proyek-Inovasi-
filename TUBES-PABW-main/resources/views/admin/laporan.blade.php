@extends('layouts.admin')

@section('title', 'Kelola Laporan')

@section('content')
    <h2 class="mb-4">📋 Kelola Laporan</h2>

    {{-- <div class="mb-3">
        <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-primary">Kelola Berita</a>
    </div> --}}

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Kategori</th>
                <th>Prioritas</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>Foto</th>
                <th>Alamat</th>
                <th>Kantor</th>
                <th>Deskripsi</th>
                <th>Status Laporan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($laporan as $item)
                <tr class="clickable-row" style="cursor:pointer"
                    data-nama="{{ e($item->nama) }}"
                    data-email="{{ e($item->email) }}"
                    data-notelp="{{ e($item->notelp) }}"
                    data-kategori="{{ e($item->kategori) }}"
                    data-prioritas="{{ e($item->prioritas) }}"
                    data-alamat="{{ e($item->alamat) }}"
                    data-polres="{{ e($item->polres) }}"
                    data-date="{{ e($item->date) }}"
                    data-time="{{ e($item->time) }}"
                    data-foto="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}"
                    data-deskripsi="{{ e($item->deskripsi) }}"
                    data-status="{{ e($item->status) }}"
                    >
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->notelp }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>
                        <span class="badge {{ $item->prioritas === 'Tinggi' ? 'bg-danger' : ($item->prioritas === 'Sedang' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            Prioritas: {{ strtoupper($item->prioritas ?? 'BELUM DITENTUKAN') }}
                        </span>
                    </td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->time }}</td>
                    <td>
                        @if ($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan"
                                style="max-width: 100px; max-height: 100px; object-fit:cover;">
                        @else
                            Tidak ada foto
                        @endif
                    </td>
                    <td>{{ $item->alamat }}</td>
                    <td>{{ $item->polres }}</td>
                    <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">{{ Str::limit($item->deskripsi, 80) }}</td>
                    <td>
                        <span
                            class="badge 
                    {{ $item->status == 'pending' ? 'bg-warning' : (in_array($item->status, ['approved', 'selesai'], true) ? 'bg-success' : 'bg-danger') }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.laporan.status', $item->id) }}" method="POST">
                            @csrf
                            <select name="status" class="form-select form-select-sm mb-1">
                                <option value="pending" @selected($item->status === 'pending')>Pending</option>
                                <option value="approved" @selected($item->status === 'approved')>Approved</option>
                                <option value="rejected" @selected($item->status === 'rejected')>Rejected</option>
                                <option value="selesai" @selected($item->status === 'selesai')>Selesai</option>
                            </select>
                            <button class="btn btn-primary btn-sm w-100">Simpan</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14">Belum ada laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Detail Modal -->
    <div id="adminDetailModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:60;">
        <div style="background:white; max-width:900px; width:95%; border-radius:8px; overflow:hidden;">
            <div class="p-3 d-flex justify-content-between align-items-center" style="border-bottom:1px solid #eee;">
                <h5 id="a-nama" class="m-0"></h5>
                <button id="a-close" class="btn btn-sm btn-light">×</button>
            </div>
            <div class="p-3 d-flex" style="gap:16px;">
                <div style="flex:0 0 45%; max-height:60vh; display:flex; align-items:center; justify-content:center;">
                    <img id="a-foto" src="" alt="Foto" style="max-width:100%; max-height:60vh; object-fit:contain; display:block;">
                </div>
                <div style="flex:1; overflow:auto; max-height:60vh;">
                    <p><strong>Email:</strong> <span id="a-email"></span></p>
                    <p><strong>No. Telp:</strong> <span id="a-notelp"></span></p>
                    <p><strong>Kategori:</strong> <span id="a-kategori"></span></p>
                    <p><strong>Prioritas:</strong> <span id="a-prioritas" class="badge bg-secondary"></span></p>
                    <p><a id="a-hubungi" class="btn btn-success btn-sm" href="#" rel="nofollow">Hubungi Pelapor</a></p>
                    <p><strong>Alamat:</strong> <span id="a-alamat"></span></p>
                    <p><strong>Kantor:</strong> <span id="a-polres"></span></p>
                    <p><strong>Tanggal:</strong> <span id="a-date"></span></p>
                    <p><strong>Waktu:</strong> <span id="a-time"></span></p>
                    <p><strong>Status:</strong> <span id="a-status"></span></p>
                    <hr>
                    <div style="white-space:pre-wrap; word-wrap:break-word;"> <strong>Deskripsi:</strong>
                        <p id="a-deskripsi" style="margin-top:6px; color:#333;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.clickable-row').forEach(function(row){
                row.addEventListener('click', function(e){
                    // if click target is inside the action form, ignore to allow status change
                    if(e.target.closest('form')) return;
                    const modal = document.getElementById('adminDetailModal');
                    document.getElementById('a-nama').textContent = row.dataset.nama || '';
                    document.getElementById('a-email').textContent = row.dataset.email || '';
                    document.getElementById('a-notelp').textContent = row.dataset.notelp || '';
                    document.getElementById('a-kategori').textContent = row.dataset.kategori || '';
                    const prioritas = row.dataset.prioritas || 'Belum ditentukan';
                    const prioritasElement = document.getElementById('a-prioritas');
                    prioritasElement.textContent = 'Prioritas: ' + prioritas.toUpperCase();
                    prioritasElement.className = 'badge ' + (prioritas === 'Tinggi' ? 'bg-danger' : (prioritas === 'Sedang' ? 'bg-warning text-dark' : 'bg-secondary'));
                    document.getElementById('a-hubungi').href = row.dataset.notelp ? 'tel:' + row.dataset.notelp : '#';
                    document.getElementById('a-alamat').textContent = row.dataset.alamat || '';
                    document.getElementById('a-polres').textContent = row.dataset.polres || '';
                    document.getElementById('a-date').textContent = row.dataset.date || '';
                    document.getElementById('a-time').textContent = row.dataset.time || '';
                    document.getElementById('a-status').textContent = row.dataset.status || '';
                    const foto = row.dataset.foto || '';
                    const img = document.getElementById('a-foto');
                    if(foto){ img.src = foto; img.style.display = 'block'; } else { img.style.display = 'none'; }
                    document.getElementById('a-deskripsi').textContent = row.dataset.deskripsi || '';
                    modal.style.display = 'flex';
                });
            });

            document.getElementById('a-close').addEventListener('click', function(){
                document.getElementById('adminDetailModal').style.display = 'none';
            });

            document.getElementById('adminDetailModal').addEventListener('click', function(e){
                if(e.target.id === 'adminDetailModal') this.style.display = 'none';
            });
        });
    </script>
@endsection
