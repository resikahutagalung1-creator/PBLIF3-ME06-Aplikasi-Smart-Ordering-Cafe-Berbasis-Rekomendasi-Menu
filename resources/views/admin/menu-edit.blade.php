
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Smart Cafe</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="admin-container">

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

    <main class="main">

        <div class="top-bar">
            <div class="staff">
                <div class="staff-icon">👤</div>
                <span>Admin</span>

                <a href="{{ route('admin.logout') }}" class="admin-top-logout">
                    Logout
                </a>
            </div>
        </div>

        <div class="content">

            <div class="page-title">
                <h1>Edit Menu</h1>
                <p>Ubah informasi menu Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            @if ($errors->any())
                <div style="background:#fee2e2;color:#b91c1c;padding:12px;border-radius:8px;margin-bottom:20px;">
                    <ul style="margin:0;padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card" style="padding:30px;">

                <form action="{{ route('admin.menu.update', $menu->menu_id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Nama Menu</label>

                        <input type="text"
                               name="nama_menu"
                               value="{{ old('nama_menu', $menu->nama_menu) }}"
                               required
                               placeholder="Masukkan nama menu"
                               style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;">
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Kategori</label>

                        <select name="kategori_id"
                                required
                                style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;background:white;">

                            <option value="">-- Pilih Kategori --</option>

                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori->kategori_id }}"
                                    {{ old('kategori_id', $menu->kategori_id) == $kategori->kategori_id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Deskripsi</label>

                        <textarea name="deskripsi"
                                  rows="4"
                                  placeholder="Masukkan deskripsi menu"
                                  style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Harga (Rp)</label>

                        <input type="number"
                               name="harga"
                               value="{{ old('harga', $menu->harga) }}"
                               min="0"
                               required
                               placeholder="Masukkan harga"
                               style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;">
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Stok</label>

                        <input type="number"
                               name="stok"
                               value="{{ old('stok', $menu->stok) }}"
                               min="0"
                               required
                               placeholder="Masukkan stok"
                               style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;">
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Gambar Menu Saat Ini</label>

                        @if ($menu->gambar)
                            <div style="margin-top:10px;">
                                <img src="{{ asset('images/menu/' . $menu->gambar) }}"
                                     alt="{{ $menu->nama_menu }}"
                                     style="width:150px;height:150px;object-fit:cover;border-radius:10px;">
                            </div>
                        @else
                            <p>Belum ada gambar.</p>
                        @endif
                    </div>

                    <div style="margin-bottom:20px;">
                        <label style="display:block;margin-bottom:10px;">Ganti Gambar Menu (Opsional)</label>

                        <input type="file"
                               name="gambar"
                               accept="image/jpeg,image/png,image/webp"
                               style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;">

                        <small style="display:block;margin-top:8px;">
                            Biarkan kosong jika tidak ingin mengganti gambar. Format JPG, JPEG, PNG atau WEBP.
                        </small>
                    </div>

                    <div style="margin-bottom:30px;">
                        <label style="display:block;margin-bottom:10px;">Status Menu</label>

                        <select name="status"
                                required
                                style="width:100%;padding:14px 18px;border:1px solid #ddd;border-radius:10px;box-sizing:border-box;background:white;">

                            <option value="tersedia"
                                {{ old('status', $menu->status) == 'tersedia' ? 'selected' : '' }}>
                                Tersedia
                            </option>

                            <option value="habis"
                                {{ old('status', $menu->status) == 'habis' ? 'selected' : '' }}>
                                Habis
                            </option>

                        </select>
                    </div>

                    <button type="submit"
                            style="background:#8b5e3c;color:white;padding:12px 26px;border:0;border-radius:10px;font-size:16px;cursor:pointer;">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.menu') }}"
                       style="display:inline-block;background:#eee;color:#222;padding:12px 26px;border-radius:10px;text-decoration:none;font-size:16px;margin-left:12px;">
                        Batal
                    </a>

                </form>

            </div>

        </div>

    </main>

</div>

</body>
</html>
