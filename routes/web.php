<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
    return view('welcome');
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
| LOGIN ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/login', [AdminController::class, 'login'])
    ->name('admin.login.process');

Route::middleware('admin')->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

});

/*
|--------------------------------------------------------------------------
| MENU
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


/*
|--------------------------------------------------------------------------
| RINGKASAN PESANAN
|--------------------------------------------------------------------------
*/

Route::get('/ringkasan-pesanan', [PesananController::class, 'ringkasan'])
    ->name('pesanan.ringkasan');


/*
|--------------------------------------------------------------------------
| PEMBAYARAN
|--------------------------------------------------------------------------
*/

Route::get('/pembayaran', [PesananController::class, 'pembayaran'])
    ->name('pesanan.pembayaran');


/*
|--------------------------------------------------------------------------
| UPDATE KERANJANG
|--------------------------------------------------------------------------
*/

Route::post('/pesanan/keranjang/update', [PesananController::class, 'updateKeranjang'])
    ->name('pesanan.keranjang.update');


/*
|--------------------------------------------------------------------------
| KOSONGKAN KERANJANG
|--------------------------------------------------------------------------
*/

Route::post('/pesanan/keranjang/kosongkan', [PesananController::class, 'kosongkanKeranjang'])
    ->name('pesanan.keranjang.kosongkan');


/*
|--------------------------------------------------------------------------
| KASIR
|--------------------------------------------------------------------------
*/

Route::get('/kasir/login', function () {return view('kasir.login');});

Route::post('/kasir/login', [KasirController::class, 'login']);

Route::get('/kasir/logout', function () {
    session()->flush();

    return redirect('/kasir/login');});

Route::middleware('kasir')->group(function () {

Route::get('/kasir/dashboard', [KasirController::class, 'dashboard']);

Route::get('/kasir/pesanan-masuk', [KasirController::class, 'pesananMasuk']);

Route::get('/kasir/detail/{id}', [KasirController::class, 'detail']);

Route::post('/kasir/pesanan/terima/{id}', [KasirController::class, 'terimaPesanan']);

Route::post('/kasir/pesanan/selesai/{id}', [KasirController::class, 'selesaiPesanan']);

Route::post('/kasir/pesanan/batalkan/{id}', [KasirController::class, 'batalkanPesanan']);

Route::get('/kasir/proses', [KasirController::class, 'proses']);

Route::get('/kasir/transaksi', [KasirController::class, 'transaksi']);

Route::post('/kasir/pembayaran/konfirmasi/{id}', [KasirController::class, 'konfirmasiPembayaran']);

Route::get('/kasir/riwayat', [KasirController::class, 'riwayat']);
});