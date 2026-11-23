
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

    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon">☕</div>
            <div class="logo-text">
                <div class="logo-title">SMART CAFE</div>
                <div class="logo-subtitle">Smart Ordering Cafe</div>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li><a href="/kasir/dashboard"><span class="menu-icon">⌂</span><span class="menu-text">Dashboard</span></a></li>
            <li><a href="/kasir/pesanan-masuk"><span class="menu-icon">▤</span><span class="menu-text">Pesanan Masuk</span></a></li>
            <li><a href="/kasir/proses" class="active"><span class="menu-icon">◷</span><span class="menu-text">Proses</span></a></li>
            <li><a href="/kasir/transaksi"><span class="menu-icon">▥</span><span class="menu-text">Transaksi</span></a></li>
            <li><a href="/kasir/riwayat"><span class="menu-icon">◷</span><span class="menu-text">Riwayat</span></a></li>
        </ul>

        <div class="sidebar-bottom">
            <div class="sidebar-coffee">☕</div>
            <div>Good Food</div>
            <div>Better Mood</div>
            <div class="sidebar-bottom-line"></div>
        </div>
    </aside>

    <main class="main">
        <div class="top-bar">
            <div class="staff">
                <div class="staff-icon">👤</div>
                <span>Kasir</span>
                <span class="staff-arrow">⌄</span>
            </div>
        </div>

        <div class="content">
            <div class="page-title">
                <h1>Proses Pesanan</h1>
                <p>Perbarui tahapan pesanan pelanggan.</p>
                <div class="title-line"></div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @forelse ($pesanan as $item)
                @php
                    $tahapan = [
                        'Diproses',
                        'Hampir Siap',
                        'Siap Disajikan',
                        'Selesai'
                    ];

                    $posisi = array_search($item->status, $tahapan);
                @endphp

                <div class="card process-card">

                    <div class="process-header">
                        <div>
                            <h2>Proses Pesanan {{ $item->nomor_pesanan }}</h2>
                            <p>Perkembangan pesanan pelanggan.</p>
                        </div>

                        <span class="status status-diproses">
                            {{ $item->status }}
                        </span>
                    </div>

                    <div class="timeline">
                        @foreach ($tahapan as $index => $tahap)
                            <div class="timeline-step">
                                <div class="timeline-circle {{ $posisi !== false && $index <= $posisi ? '' : 'inactive' }}">
                                    {{ $posisi !== false && $index <= $posisi ? '✓' : '●' }}
                                </div>
                                <div class="timeline-label {{ $posisi !== false && $index <= $posisi ? 'active' : '' }}">
                                    {{ $tahap }}
                                </div>
                            </div>

                            @if (!$loop->last)
                                <div class="timeline-line"></div>
                            @endif
                        @endforeach
                    </div>

                    <div class="process-illustration">
                        <div class="chef-emoji">👨‍🍳</div>
                    </div>

                    <div class="process-text">
                        @switch($item->status)
                            @case('Diproses')
                                Pesanan sedang disiapkan...
                                @break
                            @case('Hampir Siap')
                                Pesanan hampir selesai disiapkan...
                                @break
                            @case('Siap Disajikan')
                                Pesanan siap disajikan kepada pelanggan.
                                @break
                            @default
                                Pesanan telah selesai.
                        @endswitch
                    </div>

                    <div class="process-info">
                        <div>
                            <span>Nama Pelanggan</span>
                            <strong>{{ $item->pelanggan->nama ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Meja</span>
                            <strong>{{ $item->pelanggan->nomor_meja ?? '-' }}</strong>
                        </div>

                        <div>
                            <span>Total</span>
                            <strong>Rp{{ number_format($item->total, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div class="process-action">
                        @if ($item->status !== 'Selesai')
                            <form action="{{ route('kasir.updateTahap', $item->pesanan_id) }}" method="POST">
                                @csrf

                                <label for="status-{{ $item->pesanan_id }}">
                                    Perbarui Tahapan Pesanan
                                </label>

                                <select
                                    name="status"
                                    id="status-{{ $item->pesanan_id }}"
                                    required
                                >
                                    @foreach ($tahapan as $tahap)
                                        @if ($tahap !== 'Diproses' && array_search($tahap, $tahapan) > $posisi)
                                            <option value="{{ $tahap }}">
                                                {{ $tahap }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                <button type="submit" class="btn-terima">
                                    Perbarui Status
                                </button>
                            </form>
                        @endif
                    </div>

                </div>

            @empty
                <div class="card process-card">
                    <div class="process-empty">
                        <div class="process-empty-icon">☕</div>
                        <h3>Tidak ada pesanan yang sedang diproses</h3>
                        <p>Pesanan yang sudah diterima akan muncul di halaman ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </main>
</div>

<script src="{{ asset('js/kasir.js') }}"></script>
</body>
</html>