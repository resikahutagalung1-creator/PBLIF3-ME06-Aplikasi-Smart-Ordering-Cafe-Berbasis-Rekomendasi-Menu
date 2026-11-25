<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna - Smart Cafe</title>
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
            <li><a href="{{ route('admin.dashboard') }}"><span class="menu-icon">⌂</span><span class="menu-text">Dashboard</span></a></li>
            <li><a href="{{ route('admin.menu') }}"><span class="menu-icon">▤</span><span class="menu-text">Kelola Menu</span></a></li>
            <li><a href="{{ route('admin.pengguna') }}" class="active"><span class="menu-icon">♙</span><span class="menu-text">Kelola Data Pengguna</span></a></li>
            <li><a href="{{ route('admin.meja') }}"><span class="menu-icon">▦</span><span class="menu-text">Kelola Meja</span></a></li>
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
                <a href="{{ route('admin.logout') }}" class="admin-top-logout">Logout</a>
            </div>
        </div>

        <div class="content">
            <div class="page-title">
                <h1>Edit Data Pengguna</h1>
                <p>Perbarui informasi akun pengguna Smart Cafe.</p>
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

            <div class="card" style="padding:25px;">
                <form action="{{ route('admin.pengguna.update', $pengguna->user_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div style="margin-bottom:18px;">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}" required
                            style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;">
                    </div>

                    <div style="margin-bottom:18px;">
                        <label>Username</label>
                        <input type="text"
                        name="username"
                        value="{{ old('username', $pengguna->username) }}"
                        required
                        style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;">
                    </div>

                    <div style="margin-bottom:18px;">
                        <label>Password Baru</label>
                        <input type="password" name="password" minlength="6"
                            placeholder="Kosongkan jika tidak ingin mengubah password"
                            style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;">
                    </div>

                    <div style="margin-bottom:18px;">
                        <label>Role</label>

                        @if($pengguna->username === 'adminsmart')
                            <input type="text" value="Admin" readonly
                                style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;background:#eee;">
                            <input type="hidden" name="role" value="admin">
                        @else
                            <select name="role" required
                                style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;">
                                <option value="admin" {{ old('role', $pengguna->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="kasir" {{ old('role', $pengguna->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                        @endif
                    </div>

                    <div style="margin-bottom:25px;">
                        <label>Status</label>

                        @if($pengguna->username === 'adminsmart')
                            <input type="text" value="Aktif" readonly
                                style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;background:#eee;">
                            <input type="hidden" name="status" value="aktif">
                        @else
                            <select name="status" required
                                style="width:100%;padding:12px;margin-top:8px;border:1px solid #ddd;border-radius:8px;">
                                <option value="aktif" {{ old('status', $pengguna->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $pengguna->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        @endif
                    </div>

                    <button type="submit"
                        style="background:#8b5e3c;color:white;padding:12px 22px;border:0;border-radius:8px;cursor:pointer;">
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.pengguna') }}"
                        style="display:inline-block;margin-left:10px;padding:12px 22px;background:#eee;color:#333;border-radius:8px;text-decoration:none;">
                        Batal
                    </a>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
