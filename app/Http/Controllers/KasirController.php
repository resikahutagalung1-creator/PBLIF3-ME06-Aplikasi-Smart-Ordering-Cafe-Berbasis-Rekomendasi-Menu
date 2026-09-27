<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pesanan;
use App\Models\Pembayaran;

class KasirController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $user = DB::table('users')
        ->where('username', $request->username)
        ->where('role', 'kasir')
        ->where('status', 'aktif')
        ->first();

    if (!$user || $request->password !== $user->password) {
        return back()
            ->withInput()
            ->with('error', 'Username atau password kasir salah.');
    }

    session([
        'kasir_login' => true,
        'kasir_id' => $user->user_id,
        'kasir_nama' => $user->nama,
        'kasir_username' => $user->username,
        'kasir_role' => $user->role,
    ]);

    return redirect('/kasir/dashboard');
}
    public function transaksi()
{
    $pembayaran = Pembayaran::with([
        'pesanan.pelanggan'
    ])
    ->orderBy('tanggal_bayar', 'desc')
    ->get();

    return view('kasir.transaksi', compact('pembayaran'));
}
    public function dashboard()
    {
        // Mengambil jumlah pesanan berdasarkan status
        $pesananBaru = Pesanan::where('status', 'Menunggu')->count();

        $diproses = Pesanan::where('status', 'Diproses')->count();

        $selesai = Pesanan::where('status', 'Selesai')->count();

        // Mengambil semua pesanan terbaru
        $pesanan = Pesanan::with('pelanggan')
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();

        return view('kasir.dashboard', compact(
            'pesananBaru',
            'diproses',
            'selesai',
            'pesanan'
        ));
    }
        public function pesananMasuk()
    {
        // Mengambil jumlah pesanan yang masih menunggu
        $pesananBaru = Pesanan::where('status', 'Menunggu')->count();

        // Mengambil pesanan dengan status Menunggu
        $pesanan = Pesanan::with('pelanggan')
            ->where('status', 'Menunggu')
            ->orderBy('tanggal_pesanan', 'desc')
            ->get();

        return view('kasir.pesanan-masuk', compact(
            'pesananBaru',
            'pesanan'
        ));
    }
    public function detail($id)
    {
        // Mengambil pesanan beserta pelanggan,
        // detail pesanan, dan menu
        $pesanan = Pesanan::with([
            'pelanggan',
            'detailPesanan.menu'
        ])->findOrFail($id);

        return view('kasir.detail', compact('pesanan'));
    }
    public function terimaPesanan($id)
    {
    $pesanan = Pesanan::findOrFail($id);

    $pesanan->status = 'Diproses';
    $pesanan->save();

    return redirect('/kasir/proses');
    }

    public function batalkanPesanan($id)
    {
    $pesanan = Pesanan::findOrFail($id);

    $pesanan->status = 'Dibatalkan';
    $pesanan->save();

    return redirect('/kasir/pesanan-masuk');
    }
    public function proses()
    {
    $pesanan = Pesanan::with([
        'pelanggan',
        'detailPesanan.menu'
    ])
    ->where('status', 'Diproses')
    ->orderBy('tanggal_pesanan', 'desc')
    ->get();

    return view('kasir.proses', compact('pesanan'));
    }

    public function selesaiPesanan($id)
    {
    $pesanan = Pesanan::findOrFail($id);

    $pesanan->status = 'Selesai';

    $pesanan->save();

   return redirect('/kasir/transaksi');
    }
   public function riwayat()
   {
    $pesanan = Pesanan::with('pelanggan')
        ->where('status', 'Selesai')
        ->whereIn(
            'pesanan_id',
            Pembayaran::where('status', 'Berhasil')
                ->pluck('pesanan_id')
        )
        ->orderBy('tanggal_pesanan', 'desc')
        ->get();

    return view('kasir.riwayat', compact('pesanan'));
    }
    public function konfirmasiPembayaran($id)
    {
    $pembayaran = Pembayaran::findOrFail($id);

    $pembayaran->status = 'Berhasil';
    $pembayaran->tanggal_bayar = now();

    $pembayaran->save();

    return redirect('/kasir/riwayat');
    }
}

