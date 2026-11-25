<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kelola Meja - Smart Cafe</title>

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
                <a href="{{ route('admin.menu') }}">
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
                <a href="{{ route('admin.meja') }}" class="active">
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

                <a href="/admin/logout" class="admin-top-logout">
                    Logout
                </a>
            </div>
        </div>

        <div class="content">

            <div class="page-title">
                <h1>Kelola Meja</h1>
                <p>Atur ketersediaan meja pelanggan Smart Cafe.</p>
                <div class="title-line"></div>
            </div>

            @if(session('success'))
                <div style="background:#e8f5e9;color:#256029;padding:12px;border-radius:8px;margin-bottom:20px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">

                <div class="card-header">

                    <div class="card-title-wrapper">
                        <div class="card-title-icon">▦</div>
                        <div class="card-title">Daftar Meja</div>
                    </div>

                </div>

                <div style="padding:20px;">

                    <!-- KOLOM PENCARIAN MEJA -->
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
                                id="searchMeja"
                                placeholder="Cari nomor meja..."
                                autocomplete="off"
                                style="width:100%;height:52px;padding:0 15px 0 46px;border:1px solid #dcc7b5;border-radius:10px;font-size:15px;outline:none;box-sizing:border-box;background:white;color:#70452B;"
                            >

                        </div>

                    </div>

                    <!-- KOTAK DAFTAR MEJA -->
                    <div id="mejaGrid"
                         style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px;">

                        @forelse($mejas as $meja)

                            <div class="meja-card"
                                 data-meja-name="Meja {{ $meja->nomor_meja }}"
                                 style="border:1px solid #ddd2c9;border-radius:12px;padding:18px;background:#fff;">

                                <h3 style="margin:0 0 12px;color:#70452B;">
                                    Meja {{ $meja->nomor_meja }}
                                </h3>

                                @if($meja->status === 'tersedia')

                                    <span style="color:#15803d;font-weight:bold;">
                                        ● Tersedia
                                    </span>

                                @else

                                    <span style="color:#dc2626;font-weight:bold;">
                                        ● Dipesan
                                    </span>

                                    <form
                                        action="{{ route('admin.meja.tersedia', $meja->meja_id) }}"
                                        method="POST"
                                        style="margin-top:15px;"
                                        onsubmit="return confirm('Yakin ingin membuka kembali meja ini?')"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            style="background:#70452B;color:white;border:0;padding:10px 14px;border-radius:7px;cursor:pointer;width:100%;"
                                        >
                                            Tersedia Kembali
                                        </button>
                                    </form>

                                @endif

                            </div>

                        @empty

                            <div style="grid-column:1/-1;text-align:center;padding:30px;color:#777;">
                                Belum ada data meja.
                            </div>

                        @endforelse

                        <!-- PESAN JIKA MEJA TIDAK DITEMUKAN -->
                        <div id="mejaNotFound"
                             style="display:none;grid-column:1/-1;text-align:center;padding:30px;color:#777;">
                            Meja tidak ditemukan.
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>

<!-- JAVASCRIPT PENCARIAN MEJA -->
<script>

    const searchMeja = document.getElementById('searchMeja');
    const mejaCards = document.querySelectorAll('.meja-card');
    const mejaNotFound = document.getElementById('mejaNotFound');

    searchMeja.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        let jumlahDitemukan = 0;

        mejaCards.forEach(function (card) {

            const nomorMeja = card.dataset.mejaName.toLowerCase();

            if (nomorMeja.includes(keyword)) {

                card.style.display = '';
                jumlahDitemukan++;

            } else {

                card.style.display = 'none';

            }

        });

        mejaNotFound.style.display =
            mejaCards.length > 0 && jumlahDitemukan === 0
                ? 'block'
                : 'none';

    });

</script>

</body>
</html>
