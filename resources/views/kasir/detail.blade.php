<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Smart Cafe</title>
    <link rel="stylesheet" href="{{ asset('css/kasir.css') }}">

    <style>
        .detail-card {
            background: white;
            border-radius: 15px;
            padding: 22px 25px;
            max-width: 850px;
            box-shadow: 0 5px 20px rgba(27, 76, 122, 0.08);
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .detail-title {
            color: #123f73;
            font-size: 20px;
            font-weight: 700;
        }

        .detail-info {
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 7px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .detail-info-label {
            color: #7894af;
        }

        .detail-info-value {
            color: #123f73;
            font-weight: 600;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 11px 0;
            border-bottom: 1px solid #edf2f6;
        }

        .menu-image {
            width: 50px;
            height: 50px;
            border-radius: 9px;
            object-fit: cover;
            background: #eef6fd;
            flex-shrink: 0;
        }

        .menu-info {
            flex: 1;
        }

        .menu-name {
            color: #123f73;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .menu-detail {
            color: #7894af;
            font-size: 12px;
        }

        .menu-subtotal {
            color: #123f73;
            font-weight: 700;
            font-size: 13px;
        }

        .total-section {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #cbdceb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 7px;
            color: #6282a6;
            font-size: 13px;
        }

        .total-final {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #e4edf5;
            color: #123f73;
            font-size: 18px;
            font-weight: 700;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .btn-terima,
        .btn-tolak {
            flex: 1;
            border: none;
            padding: 11px 20px;
            border-radius: 8px;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-terima {
            background: #19966a;
        }

        .btn-terima:hover {
            background: #147b57;
        }

        .btn-tolak {
            background: #df4040;
        }

        .btn-tolak:hover {
            background: #c83232;
        }

        .btn-kembali {
            display: inline-block;
            margin-top: 12px;
            color: #2474c1;
            text-decoration: none;
            font-size: 13px;
        }

        .catatan {
            margin-top: 15px;
            padding: 10px 12px;
            background: #eef6fd;
            border-radius: 8px;
            color: #6282a6;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .detail-card {
                padding: 18px;
            }

            .detail-header {
                gap: 10px;
                align-items: flex-start;
            }

            .menu-item {
                gap: 10px;
            }

            .menu-subtotal {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>

<div class="kasir-container">

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
                <a href="/kasir/dashboard">
                    <span class="menu-icon">⌂</span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="/kasir/pesanan-masuk">
                    <span class="menu-icon">▤</span>
                    <span class="menu-text">Pesanan Masuk</span>
                </a>
            </li>

            <li>
                <a href="/kasir/riwayat">
                    <span class="menu-icon">▥</span>
                    <span class="menu-text">Transaksi</span>
                </a>
            </li>

            <li>
                <a href="/kasir/riwayat">
                    <span class="menu-icon">◷</span>
                    <span class="menu-text">Riwayat</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-bottom">
            <div class="sidebar-coffee">☕</div>
            <div>Good Food</div>
            <div>Better Mood</div>
            <div class="sidebar-bottom-line"></div>
        </div>

    </aside>

    <!-- MAIN -->
    <main class="main">

        <div class="top-bar">
            <div class="staff">
                <div class="staff-icon">👤</div>
                <span>Kasir</span>
                <span class="staff-arrow">⌄</span>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <div class="page-title">
                <h1>Detail Pesanan</h1>
                <p>Periksa pesanan sebelum diproses.</p>
                <div class="title-line"></div>
            </div>

            @php
                $subtotal = $pesanan->detailPesanan->sum('subtotal');
                $pajak = $subtotal * 0.10;
                $total = $subtotal + $pajak;
            @endphp

            <!-- DETAIL CARD -->
            <div class="detail-card">

                <!-- HEADER -->
                <div class="detail-header">

                    <div class="detail-title">
                        Detail Pesanan #{{ $pesanan->nomor_pesanan }}
                    </div>

                    @if ($pesanan->status === 'Menunggu')
                        <span class="status status-menunggu">Menunggu</span>
                    @elseif ($pesanan->status === 'Diproses')
                        <span class="status status-diproses">Diproses</span>
                    @elseif ($pesanan->status === 'Selesai')
                        <span class="status status-selesai">Selesai</span>
                    @elseif ($pesanan->status === 'Dibatalkan')
                        <span class="status status-dibatalkan">Dibatalkan</span>
                    @endif

                </div>

                <!-- INFORMASI PELANGGAN -->
                <div class="detail-info">

                    <div class="detail-info-label">Nama</div>

                    <div class="detail-info-value">
                        {{ $pesanan->pelanggan->nama ?? '-' }}
                    </div>

                    <div class="detail-info-label">Meja</div>

                    <div class="detail-info-value">
                        {{ $pesanan->pelanggan->nomor_meja ?? '-' }}
                    </div>

                    <div class="detail-info-label">Waktu</div>

                    <div class="detail-info-value">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->translatedFormat('d F Y, H:i') }}
                    </div>

                </div>

                <!-- DAFTAR MENU -->
                <div>

                    @forelse ($pesanan->detailPesanan as $detail)

                        <div class="menu-item">

                            @if (!empty($detail->menu->gambar))

                                <img
                                    src="{{ asset('images/' . $detail->menu->gambar) }}"
                                    alt="{{ $detail->menu->nama_menu }}"
                                    class="menu-image"
                                >

                            @else

                                <div
                                    class="menu-image"
                                    style="display:flex;align-items:center;justify-content:center;font-size:23px;"
                                >
                                    ☕
                                </div>

                            @endif

                            <div class="menu-info">

                                <div class="menu-name">
                                    {{ $detail->menu->nama_menu ?? '-' }}
                                </div>

                                <div class="menu-detail">
                                    {{ $detail->jumlah }}
                                    x
                                    Rp{{ number_format($detail->harga, 0, ',', '.') }}
                                </div>

                            </div>

                            <div class="menu-subtotal">
                                Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                            </div>

                        </div>

                    @empty

                        <div class="empty-data">
                            Tidak ada menu dalam pesanan.
                        </div>

                    @endforelse

                </div>

                <!-- TOTAL -->
                <div class="total-section">

                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>
                            Rp{{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="total-row">
                        <span>Pajak (10%)</span>
                        <span>
                            Rp{{ number_format($pajak, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="total-final">
                        <span>Total</span>
                        <span>
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                </div>

                <!-- CATATAN -->
                @if (!empty($pesanan->catatan))

                    <div class="catatan">

                        <strong style="color:#123f73;">
                            Catatan:
                        </strong>

                        {{ $pesanan->catatan }}

                    </div>

                @endif

                <!-- TOMBOL -->
                @if ($pesanan->status === 'Menunggu')

                    <div class="action-buttons">

                        <form
                            action="/kasir/pesanan/terima/{{ $pesanan->pesanan_id }}"
                            method="POST"
                            style="flex:1;"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn-terima"
                            >
                                ✓ Terima Pesanan
                            </button>

                        </form>

                        <form
                            action="/kasir/pesanan/batalkan/{{ $pesanan->pesanan_id }}"
                            method="POST"
                            style="flex:1;"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="btn-tolak"
                                onclick="return confirm('Apakah kamu yakin ingin membatalkan pesanan ini?')"
                            >
                                ✕ Tolak
                            </button>

                        </form>

                    </div>

                @endif

                <a
                    href="/kasir/pesanan-masuk"
                    class="btn-kembali"
                >
                    ← Kembali ke Pesanan Masuk
                </a>

            </div>

            <!-- QUOTE -->
            <div class="bottom-quote">

                <div class="bottom-quote-icon">
                    ☕
                </div>

                <div class="bottom-quote-text">

                    <span>Setiap pesanan adalah</span>
                    <span>cerita yang berarti 💙</span>

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>