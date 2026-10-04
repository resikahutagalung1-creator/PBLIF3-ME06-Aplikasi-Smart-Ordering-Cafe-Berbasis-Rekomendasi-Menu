
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Rincian Pesanan - Smart Cafe</title>

    <link rel="stylesheet" href="{{ asset('css/rincian.css') }}">
</head>
<body>

<div class="page-container">

    <!-- HEADER -->
    <header class="header">
        <div class="brand">
            <h1>SMART CAFE</h1>
            <p>Good Food, Good Mood</p>
        </div>
    </header>

    <!-- STATUS PESANAN -->
    <section class="success-card">
        <div class="success-icon">✓</div>
        <h2>Pesanan Berhasil Dibuat!</h2>
        <p>
            Terima kasih telah memesan di Smart Cafe.
            Silakan menunggu konfirmasi dari kasir.
        </p>
    </section>

    <!-- INFORMASI PESANAN -->
    <section class="card">
        <div class="section-heading">
            <h3>Informasi Pesanan</h3>
            <span class="order-status">
                {{ $pesanan->status }}
            </span>
        </div>

        <div class="info-list">
            <div class="info-row">
                <span>Nomor Pesanan</span>
                <div class="order-number">
                    <strong id="orderNumber">
                        {{ $pesanan->nomor_pesanan }}
                    </strong>

                    <button type="button" id="copyOrderButton">
                        Salin
                    </button>
                </div>
            </div>

            <div class="info-row">
                <span>Nama Pelanggan</span>
                <strong>{{ $pesanan->pelanggan->nama }}</strong>
            </div>

            <div class="info-row">
                <span>Nomor Meja</span>
                <strong>{{ $pesanan->pelanggan->nomor_meja }}</strong>
            </div>

            <div class="info-row">
                <span>Tanggal Pesanan</span>
                <strong>
                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesanan)->format('d/m/Y H:i') }}
                </strong>
            </div>
        </div>

        <p id="copyMessage" class="copy-message"></p>
    </section>

    <!-- DAFTAR MENU -->
    <section class="card">
        <h3>Menu yang Dipesan</h3>

        <div class="menu-list">

            @foreach ($pesanan->detailPesanan as $detail)
                <div class="menu-item">

                    <div class="menu-information">
                        <h4>
                            {{ $detail->menu->nama_menu ?? 'Menu tidak tersedia' }}
                        </h4>

                        <p>
                            {{ $detail->jumlah }} ×
                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                        </p>
                    </div>

                    <strong class="menu-subtotal">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </strong>

                </div>
            @endforeach

        </div>
    </section>

    <!-- RINGKASAN PEMBAYARAN -->
    <section class="card">
        <h3>Ringkasan Pembayaran</h3>

        <div class="payment-row">
            <span>Subtotal</span>
            <strong>
                Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}
            </strong>
        </div>

        <div class="payment-row">
            <span>Pajak (10%)</span>
            <strong>
                Rp {{ number_format($pesanan->pajak, 0, ',', '.') }}
            </strong>
        </div>

        <div class="payment-row total-row">
            <span>Total Pembayaran</span>
            <strong>
                Rp {{ number_format($pesanan->total, 0, ',', '.') }}
            </strong>
        </div>
    </section>

    <!-- STATUS PEMBAYARAN -->
    <section class="card">
        <h3>Informasi Pembayaran</h3>

        <div class="info-list">
            <div class="info-row">
                <span>Metode Pembayaran</span>
                <strong>
                    {{ $pesanan->pembayaran->metode ?? '-' }}
                </strong>
            </div>

            <div class="info-row">
                <span>Status Pembayaran</span>
                <strong class="payment-status">
                    {{ $pesanan->pembayaran->status ?? 'Menunggu' }}
                </strong>
            </div>
        </div>

        <p class="payment-note">
            Pembayaran Anda sedang menunggu konfirmasi kasir.
        </p>
    </section>

    <!-- TOMBOL -->
    <a href="{{ route('menu.index') }}" class="back-button">
        Kembali ke Menu
    </a>

    <footer class="footer">
        <p>Terima kasih telah berkunjung ke Smart Cafe.</p>
        <span>Good Food, Good Mood</span>
    </footer>

</div>

<script src="{{ asset('js/rincian.js') }}"></script>

</body>
</html>