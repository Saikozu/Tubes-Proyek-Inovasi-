<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            height: 100vh;
            background: #1e293b;
            position: fixed;
            padding: 20px;
            color: white;
        }

        .sidebar a {
            color: #cbd5f5;
            display: block;
            padding: 10px;
            text-decoration: none;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #334155;
        }

        .content {
            margin-left: 260px;
            padding: 30px;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="mb-4">ADMIN PANEL</h4>

        <a href="{{ route('admin.laporan') }}">📋 Kelola Laporan</a>

        <a href="{{ route('admin.feedback') }}">💬 Kotak Tinjauan</a>

        <a href="{{ route('admin.statistik') }}">📊 Statistik</a>

        <a href="{{ route('admin.berita.index') }}">📰 Kelola Berita</a>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>
    </div>


    <div class="content">
        @yield('content')
    </div>

</body>

</html>
