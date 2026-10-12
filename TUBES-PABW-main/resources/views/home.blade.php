<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Home - Sahabat Warga</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.boxicons.com/fonts/basic/boxicons.min.css" rel="stylesheet">
</head>

<body>

    <!-- SIDEBAR -->
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
                    <li class="nav-item active">
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

    <!-- MAIN -->
    <main class="content">
        <h2>Berita & Informasi Warga</h2>

        <div class="berita-container">
            @foreach ($beritas as $berita)
                <div class="berita-card" data-id="{{ $berita->id }}" onclick="openModal({{ $berita->id }})">

                    <!-- IMAGE -->
                    <div class="berita-img">
                        <img src="{{ asset('storage/' . $berita->gambar) }}">
                    </div>

                    <!-- BODY -->
                    <div class="berita-body">
                        <h4>{{ $berita->judul }}</h4>
                        <p>{{ Str::limit($berita->deskripsi, 120) }}</p>
                        <small>{{ $berita->created_at->format('d M Y') }}</small>

                        <div class="berita-interactions" style="display: flex; align-items: center;">
                            <button class="like-btn {{ $berita->likes->count() > 0 ? 'liked' : '' }}" onclick="event.stopPropagation(); toggleLike({{ $berita->id }}, this)">
                                <i class='bx bx-heart'></i> <span class="like-count">{{ $berita->likes_count }}</span>
                            </button>
                            <span class="comments-count">
                                Komentar <span class="comment-count">{{ $berita->comments_count }}</span>
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </main>

    <!-- MODAL -->
    <div id="berita-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-left">
                <img id="modal-image" src="" alt="Berita Image">
            </div>
            <div class="modal-right">
                <div class="modal-header">
                    <h3 id="modal-title"></h3>
                    <button onclick="closeModal()">×</button>
                </div>
                <div class="modal-body">
                    <p id="modal-description"></p>
                    <div class="modal-interactions">
                        <button id="modal-like-btn" class="like-btn" onclick="toggleLikeModal()">
                            <i class='bx bx-heart'></i> <span id="modal-like-count"></span>
                        </button>
                        <span class="comments-count">
                            <i class='bx bx-comment'></i> <span id="modal-comment-count"></span>
                        </span>
                    </div>
                    <div class="comments-section">
                        <div id="comments-list"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form id="comment-form" onsubmit="submitComment(event)">
                        <input type="text" id="comment-input" placeholder="Tambahkan komentar..." required>
                        <button type="submit">Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentBeritaId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const beritasData = @json($beritas->keyBy('id'));

        function openModal(id) {
            currentBeritaId = id;
            const berita = beritasData[id];

            if (!berita) return;

            document.getElementById('modal-image').src = '{{ asset("storage/") }}/' + berita.gambar;
            document.getElementById('modal-title').textContent = berita.judul;
            document.getElementById('modal-description').textContent = berita.deskripsi;
            document.getElementById('modal-like-count').textContent = berita.likes_count;
            document.getElementById('modal-comment-count').textContent = berita.comments_count;
            document.getElementById('modal-like-btn').classList.toggle('liked', berita.likes_count > 0);

            // Load comments
            loadComments(id);

            document.getElementById('berita-modal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('berita-modal').style.display = 'none';
            document.body.style.overflow = 'auto';
            currentBeritaId = null;
        }

        function toggleLike(id, button) {
            fetch(`/berita/${id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeBtn = button || document.getElementById('modal-like-btn');
                    const countSpan = likeBtn.querySelector('.like-count') || document.getElementById('modal-like-count');
                    likeBtn.classList.toggle('liked', data.liked);
                    countSpan.textContent = data.count;

                    // Update main card
                    const mainCard = document.querySelector(`.berita-card[data-id="${id}"] .like-count`);
                    if (mainCard) mainCard.textContent = data.count;
                    const mainBtn = document.querySelector(`.berita-card[data-id="${id}"] .like-btn`);
                    if (mainBtn) mainBtn.classList.toggle('liked', data.liked);

                    // Update modal if open
                    if (document.getElementById('berita-modal').style.display !== 'none') {
                        const modalBtn = document.getElementById('modal-like-btn');
                        const modalCount = document.getElementById('modal-like-count');
                        modalBtn.classList.toggle('liked', data.liked);
                        modalCount.textContent = data.count;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function toggleLikeModal() {
            if (currentBeritaId) {
                toggleLike(currentBeritaId, document.getElementById('modal-like-btn'));
            }
        }

        function loadComments(id) {
            // For simplicity, load from initial data or fetch if needed
            const berita = beritasData[id];
            const commentsList = document.getElementById('comments-list');
            commentsList.innerHTML = '';

            if (berita && berita.comments) {
                berita.comments.forEach(comment => {
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment-item';
                    commentDiv.innerHTML = `<strong>${comment.user.name}:</strong> ${comment.body}`;
                    commentsList.appendChild(commentDiv);
                });
            }
        }

        function submitComment(event) {
            event.preventDefault();
            if (!currentBeritaId) return;

            const input = document.getElementById('comment-input');
            const body = input.value.trim();
            if (!body) return;

            fetch(`/berita/${currentBeritaId}/comment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({ body })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add to modal comments
                    const commentsList = document.getElementById('comments-list');
                    const commentDiv = document.createElement('div');
                    commentDiv.className = 'comment-item';
                    commentDiv.innerHTML = `<strong>${data.comment.user_name}:</strong> ${data.comment.body}`;
                    commentsList.appendChild(commentDiv);

                    // Update counts
                    const modalCount = document.getElementById('modal-comment-count');
                    modalCount.textContent = parseInt(modalCount.textContent) + 1;

                    const mainCount = document.querySelector(`.berita-card[data-id="${currentBeritaId}"] .comment-count`);
                    if (mainCount) mainCount.textContent = parseInt(mainCount.textContent) + 1;

                    input.value = '';
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Close modal on outside click
        document.getElementById('berita-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

</html>
