 <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Sahabat Warga - Sistem Pelaporan</title>
      <link rel="stylesheet" href="{{ asset('css/coba1.css') }}">
      <link href='https://cdn.boxicons.com/fonts/basic/boxicons.min.css' rel='stylesheet'>
      <link href='https://cdn.boxicons.com/fonts/brands/boxicons-brands.min.css' rel='stylesheet'>
  </head>

  <body>
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
                    <li class="nav-item ">
                        <a href="home" class="nav-link">
                            <i class='bx  bx-home-alt'></i>
                            <span>Home</span>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="buatlaporan" class="nav-link ">
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
                    <li class="nav-item ">
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
                        <form action="{{ route('logout') }}" method="POST" class="">
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

          <div class="report-form">
              <div class="profile-icon">
                  <img src="assets/logo.jpg" alt="Profile">
              </div>
              <h2>Sistem Pelaporan Masalah Warga</h2>
              
              <form id="form-laporan" action="{{ route('buatlaporan.simpan') }}" method="POST"
                  enctype="multipart/form-data">

                  @csrf
                  <input type="hidden" name="date" id="date">
                  <input type="hidden" name="time" id="time">

                  <div class="form-group">
                      <span class="icon"><i class='bx bx-category'></i></span>
                      <select name="kategori" id="kategori" required>
                          <option value="">-- Pilih Kategori Laporan --</option>
                          @foreach (\App\Models\BuatLaporan::KATEGORI_PRIORITAS as $kategori => $prioritas)
                              <option value="{{ $kategori }}" @selected(old('kategori') === $kategori)>{{ $kategori }}</option>
                          @endforeach
                      </select>
                  </div>

                  <div class="form-group">
                      <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"
                              class="icon icon-tabler icons-tabler-outline icon-tabler-camera">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                  d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
                              <path d="M9 13a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                          </svg></span>
                      <input type="file" name="foto" id="foto" accept="image/*,video/*" required>
                  </div>
                  <div class="form-group">
                      <span class="icon_">
                          <i class='bx bx-map'></i>
                      </span>
                      <textarea name="alamat" id="alamat"
                          placeholder="Alamat lengkap kejadian (contoh: Jl. Jendral Sudirman No. 10, Kecamatan Ilir Barat I)" required></textarea>
                  </div>

                  <div class="form-group">
                      <span class="icon">
                          <i class='bx bx-buildings'></i>
                      </span>
                      <select name="polres" id="polres" required>
                          <option value="">-- Pilih Polres --</option>
                          <option value="Polrestabes Palembang">Polrestabes Palembang</option>
                          <option value="Polsek Ilir Barat I">Polsek Ilir Barat I</option>
                          <option value="Polsek Ilir Barat II">Polsek Ilir Barat II</option>
                          <option value="Polsek Ilir Timur I">Polsek Ilir Timur I</option>
                          <option value="Polsek Ilir Timur II">Polsek Ilir Timur II</option>
                          <option value="Polsek Sukarami">Polsek Sukarami</option>
                          <option value="Polsek Seberang Ulu I">Polsek Seberang Ulu I</option>
                          <option value="Polsek Seberang Ulu II">Polsek Seberang Ulu II</option>
                          <option value="Polsek Kalidoni">Polsek Kalidoni</option>
                          <option value="Polsek Plaju">Polsek Plaju</option>
                          <option value="Polsek Kertapati">Polsek Kertapati</option>
                      </select>
                  </div>

                  <div class="form-group">
                      <span class="icon_"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"
                              class="icon icon-tabler icons-tabler-outline icon-tabler-bubble-text">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path d="M7 10h10" />
                              <path d="M9 14h5" />
                              <path
                                  d="M12.4 3a5.34 5.34 0 0 1 4.906 3.239a5.333 5.333 0 0 1 -1.195 10.6a4.26 4.26 0 0 1 -5.28 1.863l-3.831 2.298v-3.134a2.668 2.668 0 0 1 -1.795 -3.773a4.8 4.8 0 0 1 2.908 -8.933a5.33 5.33 0 0 1 4.287 -2.16" />
                          </svg></span>
                      <textarea name="deskripsi" id="deskripsi" placeholder="Deskripsi Kejadian" required></textarea>
                  </div>
                  <div class="button-container">
                      <button type="submit" class="submit-button" value="simpan">Kirim Laporan</button>
                  </div>

              </form>
          </div>
      </div>
      </div>
      <script>
          document.getElementById('form-laporan').addEventListener('submit', function () {
        const now = new Date();

        const pad = (n) => String(n).padStart(2, '0');

        const dateStr = `${now.getFullYear()}-${pad(now.getMonth() + 1)}-${pad(now.getDate())}`;
        const timeStr = `${pad(now.getHours())}:${pad(now.getMinutes())}`;

        document.getElementById('date').value = dateStr;
        document.getElementById('time').value = timeStr;
    });
      </script>
  </body>

  </html>