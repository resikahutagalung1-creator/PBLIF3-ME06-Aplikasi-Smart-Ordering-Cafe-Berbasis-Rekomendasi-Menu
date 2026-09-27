<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Riwayat Transaksi - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">

</head>

<body>

<div class="kasir-container">

    <!-- SIDEBAR -->
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

            <li>
                <a href="/kasir/proses">

                    <span class="menu-icon">
                        ◷
                    </span>

                    <span class="menu-text">
                        Proses
                    </span>

                </a>
            </li>

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

            <li>
                <a href="/kasir/riwayat" class="active">

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


    <!-- MAIN -->
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


        <!-- CONTENT -->
        <div class="content">

            <!-- JUDUL -->
            <div class="page-title">

                <h1>
                    Riwayat Transaksi
                </h1>

                <p>
                    Daftar pesanan yang telah selesai diproses.
                </p>

                <div class="title-line"></div>

            </div>


            <!-- CARD -->
            <div class="card">

                <!-- HEADER CARD -->
                <div class="card-header">

                    <div class="card-title-wrapper">

                        <div class="card-title-icon">
                            ▥
                        </div>

                        <div class="card-title">
                            Pesanan Selesai
                        </div>

                    </div>

                    <span class="status status-selesai">
                        {{ $pesanan->count() }} Pesanan
                    </span>

                </div>


                <!-- TABLE -->
                <div class="table-wrapper">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>
                                    No. Pesanan
                                </th>

                                <th>
                                    Nama Pelanggan
                                </th>

                                <th>
                                    Meja
                                </th>

                                <th>
                                    Waktu
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($pesanan as $order)

                                <tr>

                                    <!-- NOMOR PESANAN -->
                                    <td>

                                        <strong class="order-number">
                                            #{{ $order->nomor_pesanan }}
                                        </strong>

                                    </td>


                                    <!-- NAMA PELANGGAN -->
                                    <td>

                                        {{ $order->pelanggan->nama ?? '-' }}

                                    </td>


                                    <!-- MEJA -->
                                    <td>

                                        {{ $order->pelanggan->nomor_meja ?? '-' }}

                                    </td>


                                    <!-- WAKTU -->
                                    <td>

                                        {{ \Carbon\Carbon::parse(
                                            $order->tanggal_pesanan
                                        )->format('d M Y') }}

                                        <br>

                                        {{ \Carbon\Carbon::parse(
                                            $order->tanggal_pesanan
                                        )->format('H:i') }}

                                    </td>


                                    <!-- TOTAL -->
                                    <td>

                                        <span class="order-total">

                                            Rp{{ number_format(
                                                $order->total,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    </td>


                                    <!-- STATUS -->
                                    <td>

                                        <span class="status status-selesai">
                                            Selesai
                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="empty-data"
                                    >
                                        Belum ada pesanan yang selesai.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                <!-- FOOTER -->
                <div class="card-footer">

                    <div class="showing-text">

                        Menampilkan
                        {{ $pesanan->count() }}
                        pesanan selesai

                    </div>

                </div>

            </div>


            <!-- QUOTE -->
            <div class="bottom-quote">

                <div class="bottom-quote-icon">
                    ☕
                </div>

                <div class="bottom-quote-text">

                    <span>
                        Setiap pesanan adalah
                    </span>

                    <span>
                        cerita yang berarti 💙
                    </span>

                </div>

            </div>

        </div>

    </main>

</div>

</body>

</html>