<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/Notif.css') }}">

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css" rel="stylesheet">
</head>

<body>

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
                    <li class="nav-item">
                        <a href="laporansaya" class="nav-link">
                            <i class='bx  bx-clipboard-detail'></i>
                            <span>Laporan Saya</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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

    <!-- MAIN CONTENT -->
    <main>
        <div class="notification-container">

            @forelse ($notifications as $notif)
                <div class="notification">
                    <p class="notif-title">{{ $notif->title }}</p>
                    <p class="notif-message">{{ $notif->message }}</p>
                    @if($notif->laporan)
                        <div class="laporan-detail">
                            <strong>Detail Laporan:</strong><br>
                            <small>Nama: {{ $notif->laporan->nama }}</small><br>
                            <small>Email: {{ $notif->laporan->email }}</small><br>
                            <small>Deskripsi: {{ Str::limit($notif->laporan->deskripsi, 100) }}</small><br>
                            <small>Tanggal: {{ $notif->laporan->created_at->format('d M Y') }}</small><br>
                            <small>Status: {{ ucfirst($notif->laporan->status) }}</small>
                        </div>
                    @endif
                    <small class="notif-time">
                        {{ $notif->created_at->diffForHumans() }}
                    </small>
                </div>
            @empty
                <p class="empty-notif">Tidak ada notifikasi.</p>
            @endforelse

        </div>
    </main>
    <!-- JS (opsional) -->
    <script src="{{ asset('js/Notif.js') }}"></script>
</body>

</html>
