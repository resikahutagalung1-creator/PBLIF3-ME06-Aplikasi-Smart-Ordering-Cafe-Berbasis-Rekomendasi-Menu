<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Kasir - Smart Cafe</title>

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
                <a href="/kasir/dashboard" class="active">

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

                    @if ($pesananBaru > 0)

                        <span class="badge">
                            {{ $pesananBaru }}
                        </span>

                    @endif

                </a>
            </li>

            <li>
            <a href="/kasir/proses">
                <span class="menu-icon">◷</span>
                <span class="menu-text">Proses</span>
            </a>
        </li>

            <li>
                <a href="/kasir/riwayat">

                    <span class="menu-icon">
                        ▥
                    </span>

                    <span class="menu-text">
                        Transaksi
                    </span>

                </a>
            </li>

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

    <a
        href="/kasir/logout"
        style="
            margin-left: 15px;
            color: #df4040;
            text-decoration: none;
            font-weight: 600;
        "
    >
        Logout
    </a>

</div>

        </div>


        <!-- CONTENT -->
        <div class="content">

            <!-- JUDUL -->
            <div class="page-title">

                <h1>
                    Selamat Datang, Kasir!
                </h1>

                <p>
                    Semoga hari ini penuh dengan pesanan yang menyenangkan.
                </p>

                <div class="title-line"></div>

            </div>

            <!-- STATISTIK -->
            <div class="stats">

                <!-- PESANAN MASUK -->
                <div class="stat">

                    <div class="stat-icon">
                        🧾
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Pesanan Masuk
                        </div>

                        <div class="stat-number">
                            {{ $pesananBaru }}
                        </div>

                    </div>

                    <div class="stat-arrow">
                        ↗
                    </div>

                </div>

                <!-- DALAM PROSES -->
                <div class="stat">

                    <div class="stat-icon">
                        ☕
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Dalam Proses
                        </div>

                        <div class="stat-number">
                            {{ $diproses }}
                        </div>

                    </div>

                    <div class="stat-arrow">
                        →
                    </div>

                </div>

                <!-- SELESAI -->
                <div class="stat">

                    <div class="stat-icon stat-icon-success">
                        ✓
                    </div>

                    <div class="stat-content">

                        <div class="stat-title">
                            Selesai Hari Ini
                        </div>

                        <div class="stat-number">
                            {{ $selesai }}
                        </div>

                    </div>

                    <div class="stat-arrow">
                        ↗
                    </div>

                </div>

            </div>


            <!-- CARD PESANAN -->
            <div class="card">

                <!-- HEADER CARD -->
                <div class="card-header">

                    <div class="card-title-wrapper">

                        <div class="card-title-icon">
                            ▤
                        </div>

                        <div class="card-title">
                            Pesanan Masuk
                        </div>

                    </div>

                    <!-- SEARCH -->
                    <div class="search-box">

                        <span class="search-icon">
                            ⌕
                        </span>

                        <input
                            type="text"
                            id="searchPesanan"
                            placeholder="Cari nomor pesanan..."
                        >

                    </div>

                </div>

                <!-- TABLE -->
                <div class="table-wrapper">

                    <table
                        class="table"
                        id="tablePesanan"
                    >
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

                                <th>
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($pesanan as $order)
                                <tr>
                                    <td>
                                        <strong class="order-number">
                                            {{ $order->nomor_pesanan }}
                                        </strong>

                                    </td>

                                    <td>
                                        {{ $order->pelanggan->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $order->pelanggan->nomor_meja ?? '-' }}
                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse(
                                            $order->tanggal_pesanan
                                        )->format('H:i') }}

                                    </td>

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

                                    <td>

                                        @if ($order->status === 'Menunggu')

                                            <span class="status status-menunggu">
                                                Menunggu
                                            </span>

                                        @elseif ($order->status === 'Diproses')

                                            <span class="status status-diproses">
                                                Diproses
                                            </span>

                                        @elseif ($order->status === 'Selesai')

                                            <span class="status status-selesai">
                                                Selesai
                                            </span>

                                        @elseif ($order->status === 'Dibatalkan')

                                            <span class="status status-dibatalkan">
                                                Dibatalkan
                                            </span>

                                        @else

                                            <span class="status">
                                                {{ $order->status }}
                                            </span>

                                        @endif

                                    </td>

                                    <td>

                                        <a
                                            href="/kasir/detail/{{ $order->pesanan_id }}"
                                            class="btn-detail"
                                        >
                                            <span>
                                                👁
                                            </span>

                                            Detail

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="empty-data"
                                    >
                                        Belum ada pesanan masuk.
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
                        dari
                        {{ $pesanan->count() }}
                        pesanan

                    </div>

                    <div class="pagination">

                        <div class="page-button">
                            ‹
                        </div>

                        <div class="page-button active">
                            1
                        </div>

                        <div class="page-button">
                            ›
                        </div>

                    </div>

                </div>

            </div>


            <!-- QUOTE BAGIAN BAWAH -->
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


<script src="{{ asset('js/kasir.js') }}"></script>


<!-- SEARCH -->
<script>

document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById("searchPesanan");

    const tableRows =
        document.querySelectorAll("#tablePesanan tbody tr");


    searchInput.addEventListener("keyup", function () {

        const keyword =
            this.value.toLowerCase();


        tableRows.forEach(function (row) {

            const text =
                row.textContent.toLowerCase();


            if (text.includes(keyword)) {

                row.style.display = "";

            } else {

                row.style.display = "none";

            }

        });

    });

});

</script>

</body>

</html>