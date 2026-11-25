<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu Nonaktif - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <div class="logo-icon">☕</div>

            <div class="logo-text">
                <div class="logo-title">SMART CAFE</div>
                <div class="logo-subtitle">Smart Ordering Cafe</div>
            </div>
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <span class="menu-icon">⌂</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.menu') }}" class="active">
                    <span class="menu-icon">▤</span>
                    <span class="menu-text">Kelola Menu</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.pengguna') }}">
                    <span class="menu-icon">♙</span>
                    <span class="menu-text">Kelola Data Pengguna</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.meja') }}">
                    <span class="menu-icon">▦</span>
                    <span class="menu-text">Kelola Meja</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-bottom">
            <div class="sidebar-coffee">☕</div>
            <div>Admin</div>
            <div>Smart Cafe</div>
            <div class="sidebar-bottom-line"></div>
        </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

        <!-- TOP BAR -->
        <div class="top-bar">
            <div class="staff">
                <div class="staff-icon">👤</div>
                <span>Admin</span>

                <a href="/admin/logout" class="admin-top-logout">
                    Logout
                </a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- JUDUL HALAMAN -->
            <div class="page-title">
                <h1>Kelola Menu</h1>
                <p>Melihat dan mengelola menu Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            <!-- NOTIFIKASI -->
            @if(session('success'))
                <div style="background:#e8f5e9;color:#256029;padding:12px;border-radius:8px;margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- HEADER -->
            <div class="card-header"
                 style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:15px;">

                <div class="card-title-wrapper">
                    <div class="card-title-icon">☕</div>
                    <div class="card-title">Daftar Menu Cafe</div>
                </div>

                <a href="{{ route('admin.menu.create') }}"
                   style="background:#8b5e3c;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;font-weight:600;">
                    + Tambah Menu
                </a>

            </div>

            <!-- TAB MENU -->
            <div style="padding:20px 20px 0;">

                <div style="display:flex;gap:10px;border-bottom:1px solid #ddd;padding-bottom:12px;">

                    <a href="{{ route('admin.menu') }}"
                       style="background:#f3f3f3;color:#555;padding:9px 18px;border-radius:8px;text-decoration:none;font-weight:600;">
                        Menu Aktif
                    </a>

                    <a href="{{ route('admin.menu.nonaktif.list') }}"
                       style="background:#70452B;color:white;padding:9px 18px;border-radius:8px;text-decoration:none;font-weight:600;">
                        Menu Nonaktif
                    </a>

                </div>

            </div>

            <!-- DAFTAR MENU NONAKTIF -->
            <div style="padding:20px;">

                <!-- KOLOM PENCARIAN MENU -->
                <div style="display:flex;justify-content:flex-end;margin-bottom:20px;">

                    <div style="position:relative;width:360px;max-width:100%;">

                        <!-- IKON KACA PEMBESAR -->
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#8b735f"
                            stroke-width="1.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            style="position:absolute;left:15px;top:50%;transform:translateY(-50%);pointer-events:none;"
                        >
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="m20 20-4-4"></path>
                        </svg>

                        <!-- INPUT PENCARIAN -->
                        <input
                            type="text"
                            id="searchMenu"
                            placeholder="Cari nama menu..."
                            autocomplete="off"
                            style="width:100%;height:52px;padding:0 15px 0 46px;border:1px solid #dcc7b5;border-radius:10px;font-size:15px;outline:none;box-sizing:border-box;background:white;color:#70452B;"
                        >

                    </div>

                </div>

                <!-- KOTAK MENU NONAKTIF -->
                <div id="menuGrid"
                     style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px;">

                    @forelse($menus as $menu)

                        <div class="menu-card"
                             data-menu-name="{{ $menu->nama_menu }}"
                             style="border:1px solid #ddd2c9;border-radius:12px;padding:18px;background:#fff;">

                            @if($menu->gambar)

                                <img src="{{ asset('images/menu/' . $menu->gambar) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     style="width:100%;height:145px;object-fit:cover;border-radius:8px;">

                            @else

                                <div style="width:100%;height:145px;background:#f3eee9;border-radius:8px;display:flex;align-items:center;justify-content:center;color:#888;">
                                    Tidak ada gambar
                                </div>

                            @endif

                            <h3 style="margin:12px 0;color:#70452B;">
                                {{ $menu->nama_menu }}
                            </h3>

                            <p style="margin:8px 0;color:#777;">
                                {{ $menu->kategori->nama_kategori ?? '-' }}
                            </p>

                            <p style="margin:8px 0;color:#70452B;font-weight:bold;">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </p>

                            <p style="margin:8px 0;">
                                Stok: {{ $menu->stok }}
                            </p>

                            <span style="color:#dc2626;font-weight:bold;">
                                ● Nonaktif
                            </span>

                            <div style="margin-top:15px;">

                                <form action="{{ route('admin.menu.aktif', $menu->menu_id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Aktifkan kembali menu ini?')">

                                    @csrf

                                    <button type="submit"
                                            style="background:#70452B;color:white;border:0;padding:10px 14px;border-radius:8px;cursor:pointer;width:100%;">
                                        Aktifkan Kembali
                                    </button>

                                </form>

                            </div>

                        </div>

                    @empty

                        <div style="grid-column:1/-1;text-align:center;padding:30px;color:#777;">
                            Belum ada menu yang dinonaktifkan.
                        </div>

                    @endforelse

                    <!-- PESAN JIKA MENU TIDAK DITEMUKAN -->
                    <div id="menuNotFound"
                         style="display:none;grid-column:1/-1;text-align:center;padding:30px;color:#777;">
                        Menu tidak ditemukan.
                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

<!-- JAVASCRIPT PENCARIAN MENU -->
<script>

    const searchMenu = document.getElementById('searchMenu');
    const menuCards = document.querySelectorAll('.menu-card');
    const menuNotFound = document.getElementById('menuNotFound');

    searchMenu.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        let jumlahDitemukan = 0;

        menuCards.forEach(function (card) {

            const namaMenu = card.dataset.menuName.toLowerCase();

            if (namaMenu.includes(keyword)) {

                card.style.display = '';
                jumlahDitemukan++;

            } else {

                card.style.display = 'none';

            }

        });

        if (menuCards.length > 0 && jumlahDitemukan === 0) {

            menuNotFound.style.display = 'block';

        } else {

            menuNotFound.style.display = 'none';

        }

    });

</script>

</body>
</html>
