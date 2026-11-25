<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Masuk - Smart Cafe</title>

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
                <a href="/kasir/pesanan-masuk" class="active">

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
            <a href="/kasir/transaksi">
        <span class="menu-icon">▥</span>
        <span class="menu-text">Transaksi</span>
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
                    Pesanan Masuk
                </h1>
                @if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif
                <p>
                    Daftar pesanan baru yang menunggu untuk diproses.
                </p>

                <div class="title-line"></div>

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
                            Pesanan Menunggu
                        </div>

                    </div>


                    <!-- JUMLAH PESANAN -->
                    <span class="status status-menunggu">
                        {{ $pesananBaru }} Pesanan
                    </span>

                </div>

                 </div>

                <!-- PENCARIAN PESANAN -->
                <div class="search-pesanan">
    <div class="search-input-wrapper">
        <i data-lucide="search" class="search-icon"></i>
        <input
            type="text"
            id="searchPesananMasuk"
            placeholder="Cari pesanan..."
        >
    </div>
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
                                            #{{ $order->nomor_pesanan }}
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

                                        <span class="status status-menunggu">
                                            Menunggu
                                        </span>

                                    </td>

                                   <td>
                                    <div class="aksi-pesanan">
                                        <form
                                        action="/kasir/pesanan/terima/{{ $order->pesanan_id }}"
                                        method="POST"
                                        onsubmit="return confirm('Terima pesanan ini?')"
                                        >@csrf
                                        <button type="submit" class="btn-terima">
                                            ✓ Terima
                                        </button>
                                    </form>
                                    <a
                                    href="/kasir/detail/{{ $order->pesanan_id }}"
                                    class="btn-detail"
                                    >👁 Detail
                                </a>
                            </div>
                        </td>


                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="empty-data"
                                    >
                                        Belum ada pesanan yang menunggu.
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
                        pesanan menunggu

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
<script>
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("searchPesananMasuk");
    const tbody = document.querySelector(".table tbody");

    const rows = Array.from(tbody.querySelectorAll("tr"))
        .filter(row => !row.querySelector(".empty-data"));

    const noResult = document.createElement("tr");

    noResult.innerHTML = `
        <td colspan="7" class="empty-data">
            Pesanan yang dicari tidak ditemukan.
        </td>
    `;

    input.addEventListener("input", function () {

        const keyword = input.value.toLowerCase().trim();
        let jumlahTampil = 0;

        rows.forEach(function (row) {
            const cocok = row.textContent.toLowerCase().includes(keyword);

            row.style.display = cocok ? "" : "none";

            if (cocok) {
                jumlahTampil++;
            }
        });

        if (jumlahTampil === 0 && rows.length > 0) {
            tbody.appendChild(noResult);
        } else {
            noResult.remove();
        }

    });

});
</script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>
</body>

</html>