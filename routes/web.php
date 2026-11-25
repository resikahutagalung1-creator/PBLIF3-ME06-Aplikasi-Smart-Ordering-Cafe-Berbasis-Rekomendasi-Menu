<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $menus = Menu::where('status', 'tersedia')
        ->orderBy('terjual', 'desc')
        ->take(4)
        ->get();

    return view('welcome', compact('menus'));
})->name('welcome');

/*
|--------------------------------------------------------------------------
| PELANGGAN
|--------------------------------------------------------------------------
*/

Route::get('/pelanggan', [PelangganController::class, 'index'])
    ->name('pelanggan.index');

Route::post('/pelanggan/mulai', [PelangganController::class, 'mulai'])
    ->name('pelanggan.mulai');

/*
|--------------------------------------------------------------------------
| LOGIN ADMIN DAN KASIR
|--------------------------------------------------------------------------
*/

Route::get('/login', function (Request $request) {
    $role = $request->query('role');

    if ($role === 'kasir') {
        return view('kasir.login');
    }

    return view('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::post('/login', [AdminController::class, 'login'])
    ->name('admin.login.process');

Route::get('/admin/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('admin.logout');

/*
|--------------------------------------------------------------------------
| FITUR ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware('admin')->group(function () {

    // DASHBOARD
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // KELOLA MEJA
    Route::get('/admin/meja', [AdminController::class, 'kelolaMeja'])
        ->name('admin.meja');

    Route::patch('/admin/meja/{id}/tersedia', [AdminController::class, 'tersediaKembali'])
        ->name('admin.meja.tersedia');

    // KELOLA MENU
    Route::get('/admin/menu', [MenuController::class, 'adminIndex'])
        ->name('admin.menu');

    Route::get('/admin/menu/nonaktif', [MenuController::class, 'nonaktif'])
    ->name('admin.menu.nonaktif.list');

    Route::post('/admin/menu/{id}/aktif', [MenuController::class, 'aktif'])
    ->name('admin.menu.aktif');

    Route::get('/admin/menu/tambah', [MenuController::class, 'create'])
        ->name('admin.menu.create');

    Route::post('/admin/menu', [MenuController::class, 'store'])
        ->name('admin.menu.store');

    Route::get('/admin/menu/{id}/edit', [MenuController::class, 'edit'])
        ->name('admin.menu.edit');

    Route::put('/admin/menu/{id}', [MenuController::class, 'update'])
        ->name('admin.menu.update');

    Route::delete('/admin/menu/{id}', [MenuController::class, 'destroy'])
        ->name('admin.menu.destroy');

    // KELOLA DATA PENGGUNA
    Route::get('/admin/pengguna', [AdminController::class, 'kelolaPengguna'])
        ->name('admin.pengguna');

    Route::get('/admin/pengguna/tambah', [AdminController::class, 'tambahPengguna'])
        ->name('admin.pengguna.tambah');

    Route::post('/admin/pengguna/simpan', [AdminController::class, 'simpanPengguna'])
        ->name('admin.pengguna.simpan');

    Route::get('/admin/pengguna/{id}/edit', [AdminController::class, 'editPengguna'])
        ->name('admin.pengguna.edit');

    Route::put('/admin/pengguna/{id}/update', [AdminController::class, 'updatePengguna'])
        ->name('admin.pengguna.update');

    Route::patch('/admin/pengguna/{id}/status', [AdminController::class, 'ubahStatusPengguna'])
        ->name('admin.pengguna.status');

    Route::delete('/admin/pengguna/{id}/hapus', [AdminController::class, 'hapusPengguna'])
        ->name('admin.pengguna.hapus');
});

/*
|--------------------------------------------------------------------------
| MENU PELANGGAN
|--------------------------------------------------------------------------
*/

Route::get('/menu', [MenuController::class, 'index'])
    ->name('menu.index');

Route::get('/menu/{id}', [MenuController::class, 'show'])
    ->name('menu.show');

/*
|--------------------------------------------------------------------------
| KERANJANG
|--------------------------------------------------------------------------
*/

Route::post('/keranjang/tambah', [PesananController::class, 'tambahKeranjang'])
    ->name('keranjang.tambah');

Route::get('/ringkasan-pesanan', [PesananController::class, 'ringkasan'])
    ->name('pesanan.ringkasan');

/*
|--------------------------------------------------------------------------
| PEMBAYARAN PELANGGAN
|--------------------------------------------------------------------------
*/

Route::get('/pembayaran', [PesananController::class, 'pembayaran'])
    ->name('pesanan.pembayaran');

Route::post('/pesanan/konfirmasi', [PesananController::class, 'konfirmasi'])
    ->name('pesanan.konfirmasi');

Route::get('/rincian-pesanan/{id}', [PesananController::class, 'rincian'])
    ->name('pesanan.rincian');

Route::get('/pesanan/{id}/cek-status', [PesananController::class, 'cekStatusPembayaran'])
    ->name('pesanan.cekStatus');

Route::get('/pesanan/{id}/status', [PesananController::class, 'statusPesanan'])
    ->name('pesanan.status');

Route::get('/status-pesanan/{id}', [PesananController::class, 'halamanStatusPesanan'])
    ->name('pesanan.halamanStatus');

/*
|--------------------------------------------------------------------------
| UPDATE DAN KOSONGKAN KERANJANG
|--------------------------------------------------------------------------
*/

Route::post('/pesanan/keranjang/update', [PesananController::class, 'updateKeranjang'])
    ->name('pesanan.keranjang.update');

Route::post('/pesanan/keranjang/kosongkan', [PesananController::class, 'kosongkanKeranjang'])
    ->name('pesanan.keranjang.kosongkan');

/*
|--------------------------------------------------------------------------
| LOGIN KASIR
|--------------------------------------------------------------------------
*/

Route::get('/kasir/login', function () {
    return view('kasir.login');
});

Route::post('/kasir/login', [KasirController::class, 'login']);

/*
|--------------------------------------------------------------------------
| LOGOUT KASIR
|--------------------------------------------------------------------------
*/

Route::get('/kasir/logout', function () {
    session()->flush();
    return redirect('/kasir/login');
});

/*
|--------------------------------------------------------------------------
| FITUR KASIR
|--------------------------------------------------------------------------
*/

Route::middleware('kasir')->group(function () {

    Route::get('/kasir/dashboard', [KasirController::class, 'dashboard']);

    Route::get('/kasir/pesanan-masuk', [KasirController::class, 'pesananMasuk']);

    Route::get('/kasir/detail/{id}', [KasirController::class, 'detail']);

    Route::post('/kasir/pesanan/terima/{id}', [KasirController::class, 'terimaPesanan']);

    Route::post('/kasir/pesanan/selesai/{id}', [KasirController::class, 'selesaiPesanan']);

    Route::post('/kasir/pesanan/batalkan/{id}', [KasirController::class, 'batalkanPesanan']);

    Route::get('/kasir/proses', [KasirController::class, 'proses']);

    Route::post('/kasir/pesanan/{id}/tahap', [KasirController::class, 'updateTahapPesanan'])
        ->name('kasir.updateTahap');

    Route::get('/kasir/transaksi', [KasirController::class, 'transaksi']);

    Route::post('/kasir/pembayaran/konfirmasi/{id}', [KasirController::class, 'konfirmasiPembayaran']);

    Route::get('/kasir/riwayat', [KasirController::class, 'riwayat']);
});

/*
|--------------------------------------------------------------------------
| MIDTRANS
|--------------------------------------------------------------------------
*/

Route::post('/midtrans/notification', [PesananController::class, 'midtransNotification'])
    ->name('midtrans.notification');
