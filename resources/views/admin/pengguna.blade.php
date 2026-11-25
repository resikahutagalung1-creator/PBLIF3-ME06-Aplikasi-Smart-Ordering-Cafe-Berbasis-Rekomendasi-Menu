
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pengguna - Smart Cafe</title>
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
                <a href="{{ route('admin.menu') }}">
                    <span class="menu-icon">▤</span>
                    <span class="menu-text">Kelola Menu</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.pengguna') }}" class="active">
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

    <!-- MAIN CONTENT -->
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
                <h1>Kelola Data Pengguna</h1>
                <p>Kelola data admin dan kasir Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            <!-- PESAN BERHASIL -->
            @if(session('success'))
                <div style="background:#e8f5e9;color:#256029;padding:12px;border-radius:8px;margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- PESAN ERROR -->
            @if(session('error'))
                <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:20px;">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:20px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="card">

                <div class="card-header">

                    <div class="card-title-wrapper">
                        <div class="card-title-icon">♙</div>
                        <div class="card-title">Daftar Data Pengguna</div>
                    </div>

                    <a href="{{ route('admin.pengguna.tambah') }}"
                       style="display:inline-flex;align-items:center;justify-content:center;background:#75472f;color:white;padding:0 20px;height:46px;border-radius:9px;text-decoration:none;font-size:16px;font-weight:bold;white-space:nowrap;">
                        + Tambah Pengguna
                    </a>

                </div>

                <!-- KOLOM PENCARIAN PENGGUNA -->
                <div style="display:flex;justify-content:flex-end;padding:20px 20px 0;">

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
                            id="searchPengguna"
                            placeholder="Cari nama atau username..."
                            autocomplete="off"
                            style="width:100%;height:52px;padding:0 15px 0 46px;border:1px solid #dcc7b5;border-radius:10px;font-size:15px;outline:none;box-sizing:border-box;background:white;color:#70452B;"
                        >

                    </div>

                </div>

                <!-- TABEL PENGGUNA -->
                <div style="padding:20px;overflow-x:auto;">

                    <table style="width:100%;border-collapse:collapse;min-width:900px;">

                        <thead>
                            <tr style="background:#f5eee8;">
                                <th style="padding:13px;text-align:left;">No</th>
                                <th style="padding:13px;text-align:left;">Nama</th>
                                <th style="padding:13px;text-align:left;">Username</th>
                                <th style="padding:13px;text-align:left;">Role</th>
                                <th style="padding:13px;text-align:left;">Status</th>
                                <th style="padding:13px;text-align:left;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($penggunas as $pengguna)

                                <tr class="pengguna-row"
                                    data-search="{{ strtolower($pengguna->nama . ' ' . $pengguna->username . ' ' . $pengguna->role . ' ' . $pengguna->status) }}"
                                    style="border-bottom:1px solid #eee;">

                                    <td style="padding:13px;">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td style="padding:13px;">
                                        {{ $pengguna->nama }}
                                    </td>

                                    <td style="padding:13px;">
                                        {{ $pengguna->username }}
                                    </td>

                                    <td style="padding:13px;">
                                        {{ ucfirst($pengguna->role) }}
                                    </td>

                                    <td style="padding:13px;">
                                        @if($pengguna->status === 'aktif')
                                            <span style="color:#15803d;font-weight:bold;">
                                                Aktif
                                            </span>
                                        @else
                                            <span style="color:#dc2626;font-weight:bold;">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td style="padding:13px;white-space:nowrap;">

                                        @if($pengguna->username === 'adminsmart')

                                            <span style="display:inline-block;background:#f5eee8;color:#75472f;padding:8px 12px;border-radius:7px;font-size:13px;font-weight:bold;">
                                                Akun Utama
                                            </span>

                                        @else

                                            <!-- TOMBOL EDIT -->
                                            <a href="{{ route('admin.pengguna.edit', $pengguna->user_id) }}"
                                               style="display:inline-block;background:#75472f;color:white;padding:8px 14px;border-radius:7px;text-decoration:none;font-size:14px;">
                                                Edit
                                            </a>

                                            <!-- TOMBOL AKTIF / NONAKTIF -->
                                            <form action="{{ route('admin.pengguna.status', $pengguna->user_id) }}"
                                                  method="POST"
                                                  style="display:inline-block;margin-left:5px;">

                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin mengubah status pengguna ini?')"
                                                    class="{{ $pengguna->status === 'aktif' ? 'btn-nonaktifkan' : 'btn-aktifkan' }}">

                                                    {{ $pengguna->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}

                                                </button>

                                            </form>

                                            <!-- TOMBOL HAPUS -->
                                            <form action="{{ route('admin.pengguna.hapus', $pengguna->user_id) }}"
                                                  method="POST"
                                                  style="display:inline-block;margin-left:5px;">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    onclick="return confirm('Yakin ingin menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan.')"
                                                    style="background:#dc2626;color:white;padding:8px 14px;border:0;border-radius:7px;cursor:pointer;font-size:14px;">

                                                    Hapus

                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" style="padding:20px;text-align:center;">
                                        Belum ada data pengguna.
                                    </td>
                                </tr>

                            @endforelse

                            <!-- PESAN JIKA PENGGUNA TIDAK DITEMUKAN -->
                            <tr id="penggunaNotFound" style="display:none;">
                                <td colspan="6" style="padding:20px;text-align:center;color:#777;">
                                    Data pengguna tidak ditemukan.
                                </td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

<!-- JAVASCRIPT PENCARIAN PENGGUNA -->
<script>

    const searchPengguna = document.getElementById('searchPengguna');
    const penggunaRows = document.querySelectorAll('.pengguna-row');
    const penggunaNotFound = document.getElementById('penggunaNotFound');

    searchPengguna.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        let jumlahDitemukan = 0;

        penggunaRows.forEach(function (row) {

            const dataPengguna = row.dataset.search;

            if (dataPengguna.includes(keyword)) {
                row.style.display = '';
                jumlahDitemukan++;
            } else {
                row.style.display = 'none';
            }

        });

        if (penggunaRows.length > 0 && jumlahDitemukan === 0) {
            penggunaNotFound.style.display = '';
        } else {
            penggunaNotFound.style.display = 'none';
        }

    });

</script>

</body>
</html>
