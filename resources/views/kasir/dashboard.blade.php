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
            <!-- CARD GRAFIK PENJUALAN -->
             <div class="card">
                <div class="card-header">
        <div class="card-title-wrapper">
            <div class="card-title-icon">▥</div>
            <div class="card-title">Grafik Penjualan Mingguan</div>
        </div>
    </div>
    <div style="padding: 20px; height: 420px; width: 100%; box-sizing: border-box;">
    <canvas id="grafikPenjualan" style="width: 100%; height: 100%;"></canvas>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
   const labels = JSON.parse('{!! json_encode($labelGrafik) !!}');
    const values = JSON.parse('{!! json_encode($nilaiGrafik) !!}');
    const totalPendapatanHariIni = Number('{{ $totalPendapatanHariIni }}');

    const canvas = document.getElementById('grafikPenjualan');

    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    function gambarGrafik() {
        const lebar = canvas.clientWidth;

        if (lebar <= 0) return;

        const tinggi = 380;
        const rasio = window.devicePixelRatio || 1;

        canvas.width = lebar * rasio;
        canvas.height = tinggi * rasio;

        ctx.setTransform(rasio, 0, 0, rasio, 0, 0);
        ctx.clearRect(0, 0, lebar, tinggi);

        const kiri = 65;
        const kanan = 15;
        const atas = 20;
        const bawah = 45;

        const areaLebar = lebar - kiri - kanan;
        const areaTinggi = tinggi - atas - bawah;

        const nilaiMaks = Math.max(...values, 0);
        const skalaMaks = nilaiMaks > 0 ? nilaiMaks * 1.2 : 100000;

        ctx.font = '11px Arial';
        ctx.textAlign = 'right';
        ctx.fillStyle = '#777';

        for (let i = 0; i <= 4; i++) {
            const y = atas + areaTinggi - (areaTinggi * i / 4);
            const nilai = skalaMaks * i / 4;

            ctx.strokeStyle = '#eeeeee';
            ctx.beginPath();
            ctx.moveTo(kiri, y);
            ctx.lineTo(lebar - kanan, y);
            ctx.stroke();

           
        }

        const jarak = areaLebar / labels.length;
        const lebarBatang = Math.min(40, jarak * 0.55);


values.forEach(function (nilai, i) {
    const tinggiBatang = (nilai / skalaMaks) * areaTinggi;
    const x = kiri + jarak * i + (jarak - lebarBatang) / 2;
    const y = atas + areaTinggi - tinggiBatang;

    // Menggambar batang grafik
    ctx.fillStyle = '#8B6B4A';
    ctx.beginPath();
    ctx.roundRect(x, y, lebarBatang, tinggiBatang, 5);
    ctx.fill();

   // Menampilkan total pendapatan di samping kiri batang
if (nilai > 0) {
    ctx.fillStyle = '#333';
    ctx.font = 'bold 12px Arial';
    ctx.textAlign = 'right';

    ctx.fillText(
        'Rp' + new Intl.NumberFormat('id-ID').format(nilai),
        x - 8,
        y + 15
    );

}

    // Menampilkan nama hari
    ctx.fillStyle = '#555';
    ctx.font = '12px Arial';
    ctx.textAlign = 'center';
    ctx.fillText(
        labels[i],
        x + lebarBatang / 2,
        tinggi - 15
    );
});


    }

    gambarGrafik();
    window.addEventListener('resize', gambarGrafik);
});
</script>

</body>
</html>
