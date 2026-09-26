<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PesananController;


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
| LOGIN STAFF
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


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