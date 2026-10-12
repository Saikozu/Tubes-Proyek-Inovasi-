<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sahabat Warga')</title>

    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css" rel="stylesheet">
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('assets/logo.jpg') }}" class="logo">
                <h3 class="site-title">Sahabat Warga</h3>
            </div>
        </div>

        <ul class="nav-menu">
            <li><a href="{{ route('home') }}">🏠 Home</a></li>
            <li><a href="{{ route('buatlaporan') }}">✍️ Buat Laporan</a></li>
            <li><a href="{{ route('laporansaya') }}">📋 Laporan Saya</a></li>
            <li><a href="{{ route('notifikasi') }}">🔔 Notifikasi</a></li>
            <li><a href="{{ route('kotaktinjauan') }}">📮 Kotak Tinjauan</a></li>

            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn">Logout</button>
                </form>
            </li>
        </ul>

        <div class="sidebar-footer">
            © 2023 Sahabat Warga
        </div>
    </div>

    <main>
        @yield('content')
    </main>

</body>

</html>
