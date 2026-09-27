<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proses Pesanan - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">

</head>

<body>

<div class="kasir-container">

    <!-- =========================================
         SIDEBAR
    ========================================== -->

    <aside class="sidebar">

        <div class="logo">

            <div class="logo-icon">
                ☕
            </div>

            <div class="logo-text">

                <div class="logo-title">
                    SMART CAFE
                </div>

                <div class="logo-subtitle">
                    Smart Ordering Cafe
                </div>

            </div>

        </div>

        <ul class="sidebar-menu">

            <!-- DASHBOARD -->

            <li>

                <a href="/kasir/dashboard">

                    <span class="menu-icon">
                        ⌂
                    </span>

                    <span class="menu-text">
                        Dashboard
                    </span>

                </a>

            </li>

            <!-- PESANAN MASUK -->

            <li>

                <a href="/kasir/pesanan-masuk">

                    <span class="menu-icon">
                        ▤
                    </span>

                    <span class="menu-text">
                        Pesanan Masuk
                    </span>

                </a>

            </li>

            <!-- PROSES -->

            <li>

                <a href="/kasir/proses" class="active">

                    <span class="menu-icon">
                        ◷
                    </span>

                    <span class="menu-text">
                        Proses
                    </span>

                </a>

            </li>

            <!-- TRANSAKSI -->

            <li>

                <a href="/kasir/transaksi">

                    <span class="menu-icon">
                        ▥
                    </span>

                    <span class="menu-text">
                        Transaksi
                    </span>

                </a>

            </li>

            <!-- RIWAYAT -->

            <li>

                <a href="/kasir/riwayat">

                    <span class="menu-icon">
                        ◷
                    </span>

                    <span class="menu-text">
                        Riwayat
                    </span>

                </a>

            </li>


        </ul>

        <!-- BAGIAN BAWAH SIDEBAR -->

        <div class="sidebar-bottom">

            <div class="sidebar-coffee">
                ☕
            </div>

            <div>
                Good Food
            </div>

            <div>
                Better Mood
            </div>

            <div class="sidebar-bottom-line"></div>

        </div>

    </aside>

    <!-- =========================================
         MAIN
    ========================================== -->

    <main class="main">


        <!-- TOP BAR -->

        <div class="top-bar">

            <div class="staff">

                <div class="staff-icon">
                    👤
                </div>

                <span>
                    Kasir
                </span>

                <span class="staff-arrow">
                    ⌄
                </span>

            </div>

        </div>

        <!-- =========================================
             CONTENT
        ========================================== -->

        <div class="content">


            <!-- JUDUL -->

            <div class="page-title">

                <h1>
                    Proses Pesanan
                </h1>

                <p>
                    Daftar pesanan yang sedang diproses.
                </p>

                <div class="title-line"></div>

            </div>

            <!-- =========================================
                 DATA PESANAN
            ========================================== -->

            @forelse ($pesanan as $item)


                <div class="card process-card">


                    <!-- HEADER PESANAN -->

                    <div class="process-header">

                        <div>

                            <h2>
                                Proses Pesanan {{ $item->nomor_pesanan }}
                            </h2>

                            <p>
                                Pesanan sedang diproses oleh kasir.
                            </p>

                        </div>


                        <span class="status status-diproses">

                            {{ $item->status }}

                        </span>

                    </div>

                    <!-- =========================================
                         TIMELINE
                    ========================================== -->

                    <div class="timeline">

                        <!-- MENUNGGU -->

                        <div class="timeline-step">

                            <div class="timeline-circle">
                                ✓
                            </div>

                            <div class="timeline-label">
                                Menunggu
                            </div>

                        </div>

                        <div class="timeline-line"></div>

                        <!-- DIPROSES -->

                        <div class="timeline-step">

                            <div class="timeline-circle">
                                ✓
                            </div>

                            <div class="timeline-label active">
                                Diproses
                            </div>

                        </div>

                        <div class="timeline-line"></div>

                        <!-- SELESAI -->

                        <div class="timeline-step">

                            <div class="timeline-circle inactive">
                                ●
                            </div>

                            <div class="timeline-label">
                                Selesai
                            </div>

                        </div>

                    </div>

                    <!-- =========================================
                         ILUSTRASI
                    ========================================== -->

                    <div class="process-illustration">

                        <div class="chef-emoji">
                            👨‍🍳
                        </div>

                    </div>

                    <!-- KETERANGAN -->

                    <div class="process-text">

                        Pesanan sedang diproses...

                    </div>

                    <!-- =========================================
                         INFORMASI PESANAN
                    ========================================== -->

                    <div class="process-info">


                        <div>

                            <span>
                                Nama Pelanggan
                            </span>

                            <strong>
                                {{ $item->pelanggan->nama ?? '-' }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Meja
                            </span>

                            <strong>
                                {{ $item->pelanggan->nomor_meja ?? '-' }}
                            </strong>

                        </div>

                        <div>

                            <span>
                                Total
                            </span>

                            <strong>

                                Rp{{ number_format(
                                    $item->total,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </strong>

                        </div>

                    </div>

                    <!-- =========================================
                         TOMBOL SELESAI
                    ========================================== -->

                    <div class="process-action">
                        <form
                        action="/kasir/pesanan/selesai/{{ $item->pesanan_id }}"
                        method="POST"
                        >
        @csrf
        <button
            type="submit"
            class="btn-terima"
        >
            ✓ Selesai
        </button>
    </form>
    </div>

            @empty

                <!-- TIDAK ADA PESANAN -->

                <div class="card process-card">

                    <div class="process-empty">

                        <div class="process-empty-icon">
                            ☕
                        </div>

                        <h3>
                            Tidak ada pesanan yang sedang diproses
                        </h3>

                        <p>
                            Pesanan yang sudah diterima akan muncul di halaman ini.
                        </p>

                    </div>

                </div>

            @endforelse

        </div>

    </main>

</div>

<script src="{{ asset('js/kasir.js') }}"></script>

</body>

</html>