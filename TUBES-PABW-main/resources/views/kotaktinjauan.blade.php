<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="css/kontak.css">
    <script src="js/kontak.js"></script>
    <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
    <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
    <title>Document</title>
</head>

<body>
    <header>
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
                    <li class="nav-item">
                        <a href="notifikasi" class="nav-link">
                            <i class='bx  bx-bell'></i>
                            <span>Notifikasi</span>
                        </a>
                    </li>
                    <li class="nav-item active">
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

    </header>

    <div class="kontak-container">

        <form method="POST" action="{{ route('feedback.store') }}" id="form-kontak" class="isikonten">
            @csrf

            <h2>Feedback</h2>

            <label>Nama:</label>
            <input type="text" placeholder="Nama" name="nama" required>

            <label>Email:</label>
            <input type="email" placeholder="Email" name="email" required>

            <label>No Telpon:</label>
            <input type="text" placeholder="+62" name="notelp" required>

            <label>Deskripsi Masukan:</label>
            <textarea placeholder="Deskripsi" name="deskripsi" rows="4" required></textarea>

            <button type="submit">Kirim</button>
            <button type="reset">Reset</button>
        </form>


    </div>

</body>

</html>
