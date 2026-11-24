
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Smart Cafe</title>
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
                <a href="/admin/logout" class="admin-top-logout">Logout</a>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <div class="page-title">
                <h1>Tambah Menu</h1>
                <p>Tambahkan menu baru ke Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            <div class="card">

                <div class="card-header">
                    <div class="card-title-wrapper">
                        <div class="card-title-icon">☕</div>
                        <div class="card-title">Form Menu Baru</div>
                    </div>
                </div>

                <form action="{{ route('admin.menu.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div style="padding:20px;">

                        <!-- NAMA MENU -->
                        <div style="margin-bottom:18px;">
                            <label>Nama Menu</label>
                            <input type="text"
                                   name="nama_menu"
                                   required
                                   placeholder="Masukkan nama menu"
                                   style="width:100%;padding:12px;margin-top:8px;">
                        </div>

                        <!-- KATEGORI -->
                        <div style="margin-bottom:18px;">
                            <label>Kategori</label>
                            <select name="kategori_id"
                                    required
                                    style="width:100%;padding:12px;margin-top:8px;">
                                <option value="">-- Pilih Kategori --</option>

                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- DESKRIPSI -->
                        <div style="margin-bottom:18px;">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"
                                      rows="4"
                                      placeholder="Masukkan deskripsi menu"
                                      style="width:100%;padding:12px;margin-top:8px;"></textarea>
                        </div>

                        <!-- HARGA -->
                        <div style="margin-bottom:18px;">
                            <label>Harga (Rp)</label>
                            <input type="number"
                                   name="harga"
                                   min="0"
                                   required
                                   placeholder="Masukkan harga"
                                   style="width:100%;padding:12px;margin-top:8px;">
                        </div>

                        <!-- STOK -->
                        <div style="margin-bottom:18px;">
                            <label>Stok</label>
                            <input type="number"
                                   name="stok"
                                   min="0"
                                   required
                                   placeholder="Masukkan stok"
                                   style="width:100%;padding:12px;margin-top:8px;">
                        </div>

                        <!-- GAMBAR -->
                        <div style="margin-bottom:18px;">
                            <label>Gambar Menu</label>
                            <input type="file"
                                   name="gambar"
                                   accept="image/*"
                                   required
                                   style="width:100%;padding:12px;margin-top:8px;">
                            <small>Format gambar JPG, JPEG, PNG atau WEBP.</small>
                        </div>

                        <!-- STATUS -->
                        <div style="margin-bottom:22px;">
                            <label>Status Menu</label>
                            <select name="status"
                                    required
                                    style="width:100%;padding:12px;margin-top:8px;">
                                <option value="tersedia">Tersedia</option>
                                <option value="habis">Habis</option>
                            </select>
                        </div>

                        <!-- BUTTON -->
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <button type="submit"
                                    style="padding:12px 20px;cursor:pointer;">
                                Simpan Menu
                            </button>

                            <a href="{{ route('admin.menu') }}"
                               style="padding:12px 20px;text-decoration:none;">
                                Batal
                            </a>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </main>
</div>

</body>
</html>
