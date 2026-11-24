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
    $hariIni = now()->toDateString();

    $awalMinggu = now()->startOfWeek()->toDateString();
    $akhirMinggu = now()->endOfWeek()->toDateString();

    $pesananBaru = Pesanan::where('status', 'Menunggu')->count();

    $diproses = Pesanan::where('status', 'Diproses')->count();

    $selesai = Pesanan::where('status', 'Selesai')
        ->whereDate('tanggal_selesai', $hariIni)
        ->count();
    $totalPendapatanHariIni = Pesanan::where('status', 'Selesai')
    ->whereDate('tanggal_selesai', $hariIni)
    ->sum('total');
    

    $dataPenjualan = Pesanan::selectRaw(
        'DATE(tanggal_selesai) as tanggal, SUM(total) as total'
    )
        ->where('status', 'Selesai')
        ->whereNotNull('tanggal_selesai')
        ->whereBetween(DB::raw('DATE(tanggal_selesai)'), [
            $awalMinggu,
            $akhirMinggu
        ])
        ->groupBy(DB::raw('DATE(tanggal_selesai)'))
        ->orderBy('tanggal')
        ->get();

    $labelGrafik = [];
    $nilaiGrafik = [];

    for ($i = 0; $i < 7; $i++) {
        $tanggal = now()->startOfWeek()->addDays($i)->toDateString();

        $labelGrafik[] = date('D', strtotime($tanggal));

        $penjualan = $dataPenjualan->firstWhere('tanggal', $tanggal);

        $nilaiGrafik[] = $penjualan ? (float) $penjualan->total : 0;
    }

    return view('kasir.dashboard', compact(
        'pesananBaru',
        'diproses',
        'selesai',
        'totalPendapatanHariIni',
        'labelGrafik',
        'nilaiGrafik'
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
    $berhasil = Pesanan::where('pesanan_id', $id)
        ->where('status', 'Menunggu')
        ->update([
            'status' => 'Diproses',
            'kasir_id' => session('kasir_id'),
        ]);

    if ($berhasil) {
        return redirect('/kasir/proses')
            ->with('success', 'Pesanan berhasil diterima dan sedang diproses.');
    }

    return redirect('/kasir/pesanan-masuk')
        ->with('error', 'Pesanan sudah diterima atau tidak ditemukan.');
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
    $pesanan = Pesanan::with(['pelanggan', 'detailPesanan.menu'])
        ->whereIn('status', [
            'Diproses',
            'Hampir Siap',
            'Siap Disajikan'
        ])
        ->orderBy('tanggal_pesanan', 'desc')
        ->get();

    return view('kasir.proses', compact('pesanan'));
}

    
public function selesaiPesanan($id)
{
    $pesanan = Pesanan::findOrFail($id);

    $pesanan->status = 'Selesai';
    $pesanan->tanggal_selesai = now();

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
  public function updateTahapPesanan(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Diproses,Hampir Siap,Siap Disajikan,Selesai',
    ]);

    $pesanan = Pesanan::findOrFail($id);
    $pesanan->status = $request->status;

    if ($request->status === 'Selesai') {
        $pesanan->tanggal_selesai = now();
    }

    $pesanan->save();

    if ($request->status === 'Selesai') {
        return redirect('/kasir/transaksi')
            ->with('success', 'Pesanan berhasil diselesaikan.');
    }

    return redirect('/kasir/proses')
        ->with('success', 'Tahapan pesanan berhasil diperbarui.');
}
}

