<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sahabat Warga</title>
    <link rel="stylesheet" href="{{ asset('css/styles2.css') }}">
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>

</head>

<body>
    @php
        use Illuminate\Support\Str;
    @endphp
    <div class="container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo-container">
                    <img src="assets/logo.jpg" alt="Sahabat Warga Logo" class="logo">
                    <h3 class="site-title">Sahabat Warga</h3>
                </div>
                <label for="sidebar-toggle" class="sidebar-toggle-label">
                    <!-- < i class='bx  bx-home-alt'  ></i>  -->
                </label>
            </div>

            <div class="sidebar-content">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="home" class="nav-link">
                            <i class='bx  bx-home-alt'></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="buatlaporan" class="nav-link">
                            <i class='bx  bx-edit'></i>
                            <span>Buat Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="laporansaya" class="nav-link">
                            <i class='bx  bx-clipboard-detail'></i>
                            <span>Laporan Saya</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="notifikasi" class="nav-link">
                            <i class='bx  bx-bell'></i>
                            <span>Notifikasi</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="kotaktinjauan" class="nav-link">
                            <i class='bx  bx-contact-book'></i>
                            <span>Kotak Tinjauan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" >
                            @csrf
                            <button type="submit" class="nav-link logout-btn">
                                <i class='bx  bx-arrow-out-right-square-half'></i> 
                                <span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="sidebar-footer">
                <p>© 2023 Sahabat Warga</p>
            </div>
        </div>

        <div class="content">
            <div class="table-container">
                <h2>Laporan Saya :</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No. Telp</th>
                            <th>Kategori</th>
                            <th>Prioritas</th>
                            <th>Alamat</th>
                            <th>Kantor</th>
                            <th>Tanggal Kejadian</th>
                            <th>Waktu Kejadian</th>
                            <th>Foto</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($buatlaporan as $laporan)
                            <tr class="clickable-row" style="cursor:pointer" data-nama="{{ e($laporan->nama) }}"
                                data-email="{{ e($laporan->email) }}" data-notelp="{{ e($laporan->notelp) }}"
                                data-kategori="{{ e($laporan->kategori) }}" data-prioritas="{{ e($laporan->prioritas) }}"
                                data-alamat="{{ e($laporan->alamat) }}" data-polres="{{ e($laporan->polres) }}"
                                data-date="{{ e($laporan->date) }}" data-time="{{ e($laporan->time) }}"
                                data-foto="{{ $laporan->foto ? asset('storage/' . $laporan->foto) : '' }}"
                                data-deskripsi="{{ e($laporan->deskripsi) }}">
                                <td>{{ $laporan->nama }}</td>
                                <td>{{ $laporan->email }}</td>
                                <td>{{ $laporan->notelp }}</td>
                                <td>{{ $laporan->kategori }}</td>
                                <td>{{ $laporan->prioritas }}</td>
                                <td>{{ $laporan->alamat }}</td>
                                <td>{{ $laporan->polres }}</td>
                                <td>{{ $laporan->date }}</td>
                                <td>{{ $laporan->time }}</td>
                                <td>
                                    @if ($laporan->foto)
                                        <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Foto Laporan"
                                            style="max-width: 100px; max-height: 100px; object-fit:cover;">
                                    @else
                                        Tidak ada foto
                                    @endif
                                </td>
                                <td
                                    style="max-width:320px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis">
                                    {{ Str::limit($laporan->deskripsi, 80) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">Belum ada laporan</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="modal"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:60;">
        <div class="modal-content"
            style="background:white; max-width:900px; width:95%; border-radius:8px; overflow:hidden;">
            <div
                style="display:flex; justify-content:space-between; align-items:center; padding:12px 16px; border-bottom:1px solid #eee;">
                <h3 id="m-nama" style="margin:0; font-size:18px;"></h3>
                <button id="modalClose" style="background:none; border:none; font-size:20px; cursor:pointer;">×</button>
            </div>
            <div style="display:flex; gap:16px; padding:16px;">
                <div
                    style="flex:0 0 45%; max-height:60vh; overflow:hidden; display:flex; align-items:center; justify-content:center;">
                    <img id="m-foto" src="" alt="Foto"
                        style="max-width:100%; max-height:60vh; object-fit:contain; display:block;">
                </div>
                <div style="flex:1; overflow:auto; max-height:60vh;">
                    <p><strong>Email:</strong> <span id="m-email"></span></p>
                    <p><strong>No. Telp:</strong> <span id="m-notelp"></span></p>
                    <p><strong>Kategori:</strong> <span id="m-kategori"></span></p>
                    <p><strong>Prioritas:</strong> <span id="m-prioritas"></span></p>
                    <p><strong>Alamat:</strong> <span id="m-alamat"></span></p>
                    <p><strong>Kantor:</strong> <span id="m-polres"></span></p>
                    <p><strong>Tanggal:</strong> <span id="m-date"></span></p>
                    <p><strong>Waktu:</strong> <span id="m-time"></span></p>
                    <hr>
                    <div style="white-space:pre-wrap; word-wrap:break-word;"> <strong>Deskripsi:</strong>
                        <p id="m-deskripsi" style="margin-top:6px; color:#333;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.clickable-row').forEach(function(row) {
                row.addEventListener('click', function() {
                    const modal = document.getElementById('detailModal');
                    document.getElementById('m-nama').textContent = row.dataset.nama || '';
                    document.getElementById('m-email').textContent = row.dataset.email || '';
                    document.getElementById('m-notelp').textContent = row.dataset.notelp || '';
                    document.getElementById('m-kategori').textContent = row.dataset.kategori || '';
                    document.getElementById('m-prioritas').textContent = row.dataset.prioritas || '';
                    document.getElementById('m-alamat').textContent = row.dataset.alamat || '';
                    document.getElementById('m-polres').textContent = row.dataset.polres || '';
                    document.getElementById('m-date').textContent = row.dataset.date || '';
                    document.getElementById('m-time').textContent = row.dataset.time || '';
                    const foto = row.dataset.foto || '';
                    const img = document.getElementById('m-foto');
                    if (foto) {
                        img.src = foto;
                        img.style.display = 'block';
                    } else {
                        img.style.display = 'none';
                    }
                    document.getElementById('m-deskripsi').textContent = row.dataset.deskripsi ||
                    '';
                    modal.style.display = 'flex';
                });
            });

            document.getElementById('modalClose').addEventListener('click', function() {
                document.getElementById('detailModal').style.display = 'none';
            });

            // close when clicking outside content
            document.getElementById('detailModal').addEventListener('click', function(e) {
                if (e.target.id === 'detailModal') this.style.display = 'none';
            });
        });
    </script>
</body>

</html>