<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Transaksi - Smart Cafe</title>

    <link
        rel="stylesheet"
        href="{{ asset('css/kasir.css') }}"
    >

</head>


<body>

<div class="kasir-container">


    <!-- =========================================
         SIDEBAR
    ========================================== -->

    <aside class="sidebar">


        <!-- LOGO -->

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


        <!-- MENU -->

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

                <a href="/kasir/proses">

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

                <a
                    href="/kasir/transaksi"
                    class="active"
                >

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


        <!-- BAGIAN BAWAH -->

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
                    Transaksi
                </h1>

                <p>
                    Kelola pembayaran pelanggan yang telah selesai diproses.
                </p>

                <div class="title-line"></div>

            </div>



            <!-- =========================================
                 DATA TRANSAKSI
            ========================================== -->

            <div class="card">


                <!-- HEADER CARD -->

                <div class="card-header">

                    <div class="card-title-wrapper">

                        <div class="card-title-icon">
                            ▥
                        </div>

                        <div class="card-title">
                            Daftar Transaksi
                        </div>

                    </div>


                    <span class="status status-diproses">

                        {{ $pembayaran->count() }} Transaksi

                    </span>

                </div>



                <!-- =====================================
                     TABLE
                ====================================== -->

                <div class="table-wrapper">

                    <table class="table">


                        <thead>

                            <tr>

                                <th>
                                    No. Pesanan
                                </th>

                                <th>
                                    Pelanggan
                                </th>

                                <th>
                                    Meja
                                </th>

                                <th>
                                    Total
                                </th>

                                <th>
                                    Metode
                                </th>

                                <th>
                                    Jumlah Bayar
                                </th>

                                <th>
                                    Kembalian
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>



                        <tbody>


                            @forelse ($pembayaran as $item)


                                <tr>


                                    <!-- NOMOR PESANAN -->

                                    <td>

                                        <strong class="order-number">

                                            {{ $item->pesanan->nomor_pesanan ?? '-' }}

                                        </strong>

                                    </td>



                                    <!-- PELANGGAN -->

                                    <td>

                                        {{ $item->pesanan->pelanggan->nama ?? '-' }}

                                    </td>



                                    <!-- MEJA -->

                                    <td>

                                        {{ $item->pesanan->pelanggan->nomor_meja ?? '-' }}

                                    </td>



                                    <!-- TOTAL PESANAN -->

                                    <td>

                                        <span class="order-total">

                                            Rp{{ number_format(
                                                $item->pesanan->total ?? 0,
                                                0,
                                                ',',
                                                '.'
                                            ) }}

                                        </span>

                                    </td>



                                    <!-- METODE -->

                                    <td>

                                        @if ($item->metode === 'QRIS')

                                            <span class="status status-diproses">
                                                QRIS
                                            </span>

                                        @else

                                            <span class="status status-menunggu">
                                                Tunai
                                            </span>

                                        @endif

                                    </td>



                                    <!-- JUMLAH BAYAR -->

                                    <td>

                                        Rp{{ number_format(
                                            $item->jumlah_bayar,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>



                                    <!-- KEMBALIAN -->

                                    <td>

                                        Rp{{ number_format(
                                            $item->kembalian,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </td>



                                    <!-- STATUS -->

                                    <td>

                                        @if ($item->status === 'Berhasil')

                                            <span class="status status-selesai">
                                                Berhasil
                                            </span>

                                        @elseif ($item->status === 'Gagal')

                                            <span class="status status-dibatalkan">
                                                Gagal
                                            </span>

                                        @else

                                            <span class="status status-menunggu">
                                                Menunggu
                                            </span>

                                        @endif

                                    </td>



                                    <!-- AKSI -->

                                    <td>

                                        @if ($item->status === 'Menunggu')

                                            <form
                                                action="/kasir/pembayaran/konfirmasi/{{ $item->pembayaran_id }}"
                                                method="POST"
                                            >

                                                @csrf

                                                <button
                                                    type="submit"
                                                    class="btn-terima"
                                                >
                                                    ✓ Konfirmasi
                                                </button>

                                            </form>

                                        @elseif ($item->status === 'Berhasil')

                                            <span class="status status-selesai">
                                                Berhasil
                                            </span>

                                        @else

                                            <span class="status status-dibatalkan">
                                                Gagal
                                            </span>

                                        @endif

                                    </td>


                                </tr>


                            @empty


                                <!-- TIDAK ADA DATA -->

                                <tr>

                                    <td
                                        colspan="9"
                                        class="empty-data"
                                    >

                                        Belum ada transaksi pembayaran.

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
                        {{ $pembayaran->count() }}
                        transaksi

                    </div>

                </div>


            </div>



            <!-- =========================================
                 KETERANGAN
            ========================================== -->

            <div class="bottom-quote">

                <div class="bottom-quote-icon">
                    💳
                </div>

                <div class="bottom-quote-text">

                    <span>
                        Pastikan pembayaran pelanggan
                    </span>

                    <span>
                        sudah dikonfirmasi dengan benar.
                    </span>

                </div>

            </div>


        </div>


    </main>


</div>


</body>

</html>