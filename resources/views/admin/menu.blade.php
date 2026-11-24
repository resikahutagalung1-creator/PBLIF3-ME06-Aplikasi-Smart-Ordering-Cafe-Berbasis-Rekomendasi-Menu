
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Menu - Smart Cafe</title>

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
                <a href="#">
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

            <div class="page-title">
                <h1>Kelola Menu</h1>
                <p>Melihat dan mengelola menu Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            <!-- CARD -->
              <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
                <div class="card-title-wrapper">
        <div class="card-title-icon">☕</div>
        <div class="card-title">Daftar Menu Cafe</div>
    </div>

    <a href="{{ route('admin.menu.tambah') }}"
       style="background:#8b5e3c; color:white; padding:10px 18px; border-radius:8px; text-decoration:none; font-weight:600;">
        + Tambah Menu
    </a>

</div>
            <!-- TAB MENU -->
<div style="display:flex; gap:10px; margin-bottom:20px; border-bottom:1px solid #ddd; padding-bottom:12px;">

    <a href="{{ route('admin.menu') }}"
       style="background:#8b5e3c; color:white; padding:9px 18px; border-radius:8px; text-decoration:none; font-weight:600;">
        Menu Aktif
    </a>

    <a href="{{ route('admin.menu.nonaktif.list') }}"
       style="background:#f3f3f3; color:#555; padding:9px 18px; border-radius:8px; text-decoration:none; font-weight:600;">
        Menu Nonaktif
    </a>

</div>
            <!-- TABEL MENU -->
            <div style="overflow-x:auto; width:100%;">

                <table border="1" cellpadding="10" cellspacing="0"
                       width="100%" style="border-collapse:collapse;">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($menus as $menu)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if ($menu->gambar)
                                        <img src="{{ asset('images/menu/' . $menu->gambar) }}"
                                             width="70"
                                             alt="{{ $menu->nama_menu }}"
                                             style="border-radius:8px; object-fit:cover;">
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $menu->nama_menu }}</td>
                                <td>{{ $menu->kategori->nama_kategori ?? '-' }}</td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>{{ $menu->stok }}</td>
                                <td>{{ ucfirst($menu->status) }}</td>

                                <td>
                                    <div style="display:flex; gap:6px; align-items:center;">
                                        <a href="{{ route('admin.menu.edit', $menu->menu_id) }}"
                                           style="background:#8b5e3c;color:white;padding:8px 12px;border-radius:6px;text-decoration:none;">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.menu.nonaktif', $menu->menu_id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus menu ini? Menu akan disembunyikan dari pelanggan, tetapi data pesanan lama tetap tersimpan.');">
                                            @csrf

                                            <button type="submit"
                                                    style="background:#b94a48;color:white;padding:8px 12px;border:none;border-radius:6px;cursor:pointer;">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;">
                                    Belum ada data menu.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>


            </div>

        </div>

    </main>

</div>

</body>
</html>
