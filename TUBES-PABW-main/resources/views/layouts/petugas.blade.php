<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Petugas')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { width: 240px; min-height: 100vh; background: #1e293b; position: fixed; padding: 20px; color: white; }
        .sidebar a { color: #cbd5f5; display: block; padding: 10px; text-decoration: none; border-radius: 6px; }
        .sidebar a:hover { background: #334155; }
        .content { margin-left: 260px; padding: 30px; }
        @media (max-width: 767px) {
            .sidebar { position: static; width: 100%; min-height: auto; }
            .content { margin-left: 0; padding: 20px 14px; }
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <h4 class="mb-4">PANEL PETUGAS</h4>
        <a href="{{ route('petugas.laporan') }}">Daftar Laporan</a>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-danger w-100">Logout</button>
        </form>
    </aside>
    <main class="content">
        @yield('content')
    </main>
</body>

</html>