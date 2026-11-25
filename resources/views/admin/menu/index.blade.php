
@extends('admin.layout')

@section('title', 'Kelola Menu - Smart Cafe')

@section('content')

<style>
    .menu-page {
        --coffee: #70452B;
        --coffee-dark: #55331F;
        --coffee-text: #3B2418;
        --muted: #8A7466;
        --line: #EFE4DC;
        color: var(--coffee-text);
        font-family: Arial, sans-serif;
    }

    /* HEADER */
    .menu-heading {
        margin-bottom: 25px;
    }

    .menu-heading h1 {
        margin: 0 0 8px;
        color: var(--coffee-text);
        font-size: 28px;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .menu-heading p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    /* STATISTIK */
    .menu-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 26px;
    }

    .menu-stat {
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        padding: 22px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(59,36,24,.045);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .menu-stat:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(59,36,24,.09);
    }

    .stat-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 14px;
        color: var(--coffee);
        background: #F5E7D9;
    }

    .stat-icon svg {
        width: 25px;
        height: 25px;
    }

    .stat-green {
        color: #28764A;
        background: #E5F4E9;
    }

    .stat-orange {
        color: #A86619;
        background: #FFF1DC;
    }

    .stat-purple {
        color: #70518A;
        background: #F0EAF6;
    }

    .stat-label {
        margin-bottom: 5px;
        color: var(--muted);
        font-size: 12px;
    }

    .stat-number {
        color: var(--coffee-text);
        font-size: 25px;
        font-weight: 750;
    }

    /* PANEL */
    .menu-panel {
        padding: 26px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 17px;
        box-shadow: 0 5px 20px rgba(59,36,24,.05);
    }

    .menu-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 23px;
    }

    .menu-toolbar h2 {
        margin: 0 0 6px;
        color: var(--coffee-text);
        font-size: 21px;
        font-weight: 750;
    }

    .menu-toolbar p {
        margin: 0;
        color: #9A8578;
        font-size: 13px;
    }

    /* TOMBOL TAMBAH */
    .btn-add {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        padding: 12px 19px;
        color: #fff;
        background: var(--coffee);
        border-radius: 10px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 4px 10px rgba(112,69,43,.15);
        transition: all .2s ease;
    }

    .btn-add svg {
        width: 18px;
        height: 18px;
    }

    .btn-add:hover {
        color: #fff;
        background: var(--coffee-dark);
        transform: translateY(-2px);
        box-shadow: 0 7px 15px rgba(112,69,43,.2);
    }

    /* FILTER */
    .menu-filters {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 13px;
        margin-bottom: 20px;
    }

    .search-wrap {
        position: relative;
    }

    .search-wrap svg {
        position: absolute;
        top: 50%;
        left: 14px;
        width: 18px;
        height: 18px;
        color: #9A8578;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .filter-control {
        box-sizing: border-box;
        width: 100%;
        min-height: 47px;
        padding: 12px 14px;
        color: var(--coffee-text);
        background: #FFFCFA;
        border: 1px solid #E7DAD0;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
        transition: border-color .2s, box-shadow .2s;
    }

    .search-wrap .filter-control {
        padding-left: 42px;
    }

    .filter-control:focus {
        border-color: #A97854;
        box-shadow: 0 0 0 3px rgba(112,69,43,.09);
    }

    /* INFO TABEL */
    .table-info {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 13px;
        color: var(--muted);
        font-size: 13px;
    }

    /* TABEL */
    .table-wrapper {
        overflow-x: auto;
        border: 1px solid #F0E8E2;
        border-radius: 12px;
    }

    .menu-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .menu-table thead {
        background: #F8EEE4;
    }

    .menu-table th {
        padding: 16px 13px;
        color: #55331F;
        text-align: left;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .2px;
        white-space: nowrap;
    }

    .menu-table td {
        padding: 15px 13px;
        border-bottom: 1px solid #F1EBE6;
        font-size: 14px;
        line-height: 1.5;
        vertical-align: middle;
    }

    .menu-table tbody tr {
        transition: background .2s ease;
    }

    .menu-table tbody tr:hover {
        background: #FCF5EF;
    }

    .menu-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .menu-photo {
        display: block;
        width: 68px;
        height: 68px;
        object-fit: cover;
        border-radius: 12px;
        background: #F3E2D0;
        border: 1px solid #EFE4DC;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .menu-photo:hover {
        transform: scale(1.07);
        box-shadow: 0 5px 14px rgba(59,36,24,.18);
    }

    .menu-name {
        color: var(--coffee-text);
        font-weight: 700;
    }

    .menu-category {
        color: #806A5D;
    }

    .menu-price {
        font-weight: 700;
        white-space: nowrap;
    }

    /* STATUS */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-tersedia {
        color: #247448;
        background: #E5F4E9;
    }

    .status-habis {
        color: #A45C16;
        background: #FFF0D9;
    }

    /* TOMBOL AKSI */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .action-buttons form {
        margin: 0;
    }

    .btn-edit,
    .btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        min-height: 36px;
        padding: 8px 11px;
        border: 0;
        border-radius: 8px;
        color: #fff;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        transition: all .2s ease;
    }

    .btn-edit svg,
    .btn-delete svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
    }

    .btn-edit {
        background: #70452B;
    }

    .btn-edit:hover {
        color: #fff;
        background: #55331F;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #DC5555;
    }

    .btn-delete:hover {
        background: #BB3434;
        transform: translateY(-2px);
    }

    .btn-add:active,
    .btn-edit:active,
    .btn-delete:active {
        transform: scale(.97);
    }

    /* PESAN */
    .alert-success,
    .alert-error {
        padding: 13px 15px;
        margin-bottom: 18px;
        border-radius: 9px;
        font-size: 14px;
    }

    .alert-success {
        color: #247448;
        background: #E5F4E9;
        border: 1px solid #D0EBDD;
    }

    .alert-error {
        color: #A13B3B;
        background: #FCE5E5;
        border: 1px solid #F4D1D1;
    }

    .empty-row {
        padding: 35px !important;
        color: #8A7466;
        text-align: center;
    }

    /* RESPONSIVE */
    @media (max-width: 1100px) {
        .menu-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .menu-panel {
            padding: 17px;
        }

        .menu-filters {
            grid-template-columns: 1fr;
        }

        .menu-heading h1 {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        .menu-stats {
            grid-template-columns: 1fr;
        }

        .menu-toolbar {
            align-items: stretch;
        }

        .btn-add {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="menu-page">

    <!-- HEADER -->
    <div class="menu-heading">
        <h1>Kelola Menu</h1>
        <p>Kelola daftar makanan dan minuman Smart Cafe dengan mudah.</p>
    </div>

    <!-- KARTU STATISTIK -->
    <div class="menu-stats">

        <div class="menu-stat">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 8h15v8a4 4 0 0 1-4 4H8a4 4 0 0 1-4-4V8Z"/>
                    <path d="M19 10h1a2 2 0 0 1 0 4h-1"/>
                    <path d="M7 4c0 1 1 1 1 2M12 4c0 1 1 1 1 2"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Menu</div>
                <div class="stat-number">{{ $menus->count() }}</div>
            </div>
        </div>

        <div class="menu-stat">
            <div class="stat-icon stat-green">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="m5 12 4 4L19 6"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Menu Tersedia</div>
                <div class="stat-number">
                    {{ $menus->where('status', 'tersedia')->count() }}
                </div>
            </div>
        </div>

        <div class="menu-stat">
            <div class="stat-icon stat-orange">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.9"
                     stroke-linecap="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 7v6M12 17h.01"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Menu Habis</div>
                <div class="stat-number">
                    {{ $menus->where('status', 'habis')->count() }}
                </div>
            </div>
        </div>

        <div class="menu-stat">
            <div class="stat-icon stat-purple">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="m18 17-5-5-4 4-3-3"/>
                    <path d="M14 7h5v5"/>
                </svg>
            </div>
            <div>
                <div class="stat-label">Total Terjual</div>
                <div class="stat-number">
                    {{ number_format($menus->sum('terjual')) }}
                </div>
            </div>
        </div>

    </div>

    <!-- PANEL DAFTAR MENU -->
    <div class="menu-panel">

        <div class="menu-toolbar">
            <div>
                <h2>Daftar Menu</h2>
                <p>Informasi dan pengelolaan menu cafe.</p>
            </div>

            <a href="{{ route('admin.menu.create') }}" class="btn-add">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Tambah Menu
            </a>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- PENCARIAN DAN FILTER -->
        <div class="menu-filters">

            <div class="search-wrap">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="m20 20-4-4"/>
                </svg>

                <input
                    type="text"
                    id="searchMenu"
                    class="filter-control"
                    placeholder="Cari nama menu..."
                >
            </div>

            <select id="filterKategori" class="filter-control">
                <option value="">Semua Kategori</option>

                @foreach($menus->pluck('kategori.nama_kategori')->filter()->unique() as $kategori)
                    <option value="{{ strtolower($kategori) }}">
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>

            <select id="filterStatus" class="filter-control">
                <option value="">Semua Status</option>
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>

        </div>

        <!-- INFORMASI TABEL -->
        <div class="table-info">
            <span>Daftar menu Smart Cafe</span>
            <span id="menuCount">
                {{ $menus->count() }} menu ditampilkan
            </span>
        </div>

        <!-- TABEL -->
        <div class="table-wrapper">
            <table class="menu-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Terjual</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($menus as $menu)

                        <tr class="menu-row"
                            data-nama="{{ strtolower($menu->nama_menu) }}"
                            data-kategori="{{ strtolower($menu->kategori->nama_kategori ?? '') }}"
                            data-status="{{ strtolower($menu->status) }}">

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($menu->gambar)
                                    <img
                                        src="{{ asset('images/menu/' . $menu->gambar) }}"
                                        alt="{{ $menu->nama_menu }}"
                                        class="menu-photo"
                                        onerror="this.style.display='none';"
                                    >
                                @else
                                    -
                                @endif
                            </td>

                            <td class="menu-name">
                                {{ $menu->nama_menu }}
                            </td>

                            <td class="menu-category">
                                {{ $menu->kategori->nama_kategori ?? '-' }}
                            </td>

                            <td class="menu-price">
                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                            </td>

                            <td>{{ $menu->stok }}</td>

                            <td>{{ $menu->terjual }}</td>

                            <td>
                                <span class="status-badge status-{{ $menu->status }}">
                                    {{ ucfirst($menu->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a
                                        href="{{ route('admin.menu.edit', $menu->menu_id) }}"
                                        class="btn-edit"
                                        title="Edit menu"
                                    >
                                        <svg viewBox="0 0 24 24" fill="none"
                                             stroke="currentColor" stroke-width="1.9"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m15 5 4 4M4 20l4-.8L19 8a2.1 2.1 0 0 0-3-3L5 16l-1 4Z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.menu.destroy', $menu->menu_id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn-delete"
                                            title="Hapus menu"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none"
                                                 stroke="currentColor" stroke-width="1.9"
                                                 stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18M8 6V4h8v2m3 0-1 14H6L5 6m4 4v6m6-6v6"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="empty-row">
                                Belum ada data menu.
                            </td>
                        </tr>

                    @endforelse

                    <tr id="noSearchResult" style="display:none;">
                        <td colspan="9" class="empty-row">
                            Menu yang dicari tidak ditemukan.
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- JAVASCRIPT PENCARIAN DAN FILTER -->
<script>
    const searchMenu = document.getElementById('searchMenu');
    const filterKategori = document.getElementById('filterKategori');
    const filterStatus = document.getElementById('filterStatus');

    function filterMenus() {

        const search = searchMenu.value.toLowerCase().trim();
        const kategori = filterKategori.value;
        const status = filterStatus.value;

        const rows = document.querySelectorAll('.menu-row');

        let visibleCount = 0;

        rows.forEach(row => {

            const nama = row.dataset.nama;
            const kategoriMenu = row.dataset.kategori;
            const statusMenu = row.dataset.status;

            const cocokNama = nama.includes(search);
            const cocokKategori =
                !kategori || kategoriMenu === kategori;
            const cocokStatus =
                !status || statusMenu === status;

            const tampil =
                cocokNama && cocokKategori && cocokStatus;

            row.style.display = tampil ? '' : 'none';

            if (tampil) {
                visibleCount++;
            }

        });

        const noResult = document.getElementById('noSearchResult');

        noResult.style.display =
            visibleCount === 0 && rows.length > 0 ? '' : 'none';

        document.getElementById('menuCount').textContent =
            visibleCount + ' menu ditampilkan';
    }

    searchMenu.addEventListener('input', filterMenus);
    filterKategori.addEventListener('change', filterMenus);
    filterStatus.addEventListener('change', filterMenus);
</script>

@endsection