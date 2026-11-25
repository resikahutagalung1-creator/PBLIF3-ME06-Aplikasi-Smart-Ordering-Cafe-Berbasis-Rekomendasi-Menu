
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

// Menampilkan halaman login sesuai role
Route::get('/login', function (Request $request) {

    $role = $request->query('role');

    if ($role === 'kasir') {
        return view('kasir.login');
    }

    return view('admin.login');

})->name('login');


/*
|--------------------------------------------------------------------------
| PROSES LOGIN ADMIN
|--------------------------------------------------------------------------
*/
// LOGIN ADMIN
Route::post('/login', [AdminController::class, 'login'])
    ->name('admin.login.process');
// LOGOUT ADMIN
Route::get('/admin/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('admin.logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/



Route::middleware('admin')->group(function () {

    // DASHBOARD ADMIN
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
| KONFIRMASI DAN RINCIAN PESANAN
|--------------------------------------------------------------------------
*/

Route::post('/pesanan/konfirmasi', [PesananController::class, 'konfirmasi'])
    ->name('pesanan.konfirmasi');

Route::get('/rincian-pesanan/{id}', [PesananController::class, 'rincian'])
    ->name('pesanan.rincian');

    Route::get('/pesanan/{id}/cek-status', [PesananController::class, 'cekStatusPembayaran'])
    ->name('pesanan.cekStatus');

    // Mengecek status pesanan pelanggan
Route::get('/pesanan/{id}/status', [PesananController::class, 'statusPesanan'])
    ->name('pesanan.status');

    Route::get('/status-pesanan/{id}', [PesananController::class, 'halamanStatusPesanan'])
    ->name('pesanan.halamanStatus');
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


Route::post('/midtrans/notification', [PesananController::class, 'midtransNotification'])
    ->name('midtrans.notification');
