<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;

class PesananController extends Controller
{
    /**
     * =========================================================
     * TAMBAH MENU KE KERANJANG
     * =========================================================
     */
    public function tambahKeranjang(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|integer',
        ]);

        $menu = Menu::where('menu_id', $request->menu_id)->first();

        if (!$menu) {
            return response()->json([
                'success' => false,
                'message' => 'Menu tidak ditemukan.'
            ], 404);
        }

        if ($menu->status !== 'tersedia') {
            return response()->json([
                'success' => false,
                'message' => 'Menu sedang tidak tersedia.'
            ], 422);
        }

        $keranjang = session('keranjang', []);

        $jumlahSekarang = 0;

        foreach ($keranjang as $item) {
            if ((int) $item['menu_id'] === (int) $menu->menu_id) {
                $jumlahSekarang = (int) $item['jumlah'];
                break;
            }
        }

        if ($jumlahSekarang >= $menu->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah pesanan melebihi stok yang tersedia.'
            ], 422);
        }

        $ditemukan = false;

        foreach ($keranjang as &$item) {
            if ((int) $item['menu_id'] === (int) $menu->menu_id) {
                $item['jumlah']++;
                $ditemukan = true;
                break;
            }
        }

        unset($item);

        if (!$ditemukan) {
            $keranjang[] = [
                'menu_id' => $menu->menu_id,
                'nama' => $menu->nama_menu,
                'harga' => (float) $menu->harga,
                'gambar' => $menu->gambar,
                'jumlah' => 1,
            ];
        }

        session([
            'keranjang' => $keranjang
        ]);

        $jumlahKeranjang = 0;

        foreach ($keranjang as $item) {
            $jumlahKeranjang += $item['jumlah'];
        }

        return response()->json([
            'success' => true,
            'message' => 'Menu berhasil ditambahkan ke keranjang.',
            'jumlah' => $jumlahKeranjang,
        ]);
    }


    /**
     * =========================================================
     * HALAMAN RINGKASAN PESANAN
     * =========================================================
     */
    public function ringkasan()
    {
        $keranjang = session('keranjang', []);

        $subtotal = 0;

        foreach ($keranjang as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        $pajak = round($subtotal * 0.10, 2);
        $total = $subtotal + $pajak;

        return view(
            'pesanan.ringkasan',
            compact('keranjang', 'subtotal', 'pajak', 'total')
        );
    }


    /**
     * =========================================================
     * HALAMAN PEMBAYARAN
     * =========================================================
     */
    public function pembayaran()
    {
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return redirect()
                ->route('menu.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = 0;

        foreach ($keranjang as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }

        $pajak = round($subtotal * 0.10, 2);
        $total = $subtotal + $pajak;

        $namaPelanggan = session('nama_pelanggan', 'Pelanggan');
        $nomorMeja = session('nomor_meja', '-');

        return view(
            'pesanan.pembayaran',
            compact(
                'keranjang',
                'subtotal',
                'pajak',
                'total',
                'namaPelanggan',
                'nomorMeja'
            )
        );
    }


    /**
     * =========================================================
     * KONFIRMASI DAN SIMPAN PESANAN
     * =========================================================
     */
    public function konfirmasi(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,tunai',
        ]);

        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang masih kosong.'
            ], 422);
        }

        $pelangganId = session('pelanggan_id');

        if (
            !$pelangganId ||
            !Pelanggan::where('pelanggan_id', $pelangganId)->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan. Silakan isi data pelanggan kembali.'
            ], 422);
        }

        foreach ($keranjang as $item) {
            if (
                empty($item['menu_id']) ||
                !isset($item['jumlah']) ||
                (int) $item['jumlah'] <= 0
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data keranjang tidak valid.'
                ], 422);
            }
        }

        try {

            $pesananId = DB::transaction(function () use (
                $keranjang,
                $pelangganId,
                $request
            ) {

                $daftarMenu = [];
                $subtotal = 0;

                /*
                 * Periksa menu dan stok terbaru.
                 * lockForUpdate mencegah stok yang sama
                 * digunakan bersamaan oleh transaksi lain.
                 */
                foreach ($keranjang as $item) {

                    $menu = Menu::where(
                        'menu_id',
                        $item['menu_id']
                    )->lockForUpdate()->first();

                    if (!$menu) {
                        throw new \DomainException(
                            'Salah satu menu tidak ditemukan.'
                        );
                    }

                    if ($menu->status !== 'tersedia') {
                        throw new \DomainException(
                            'Menu ' . $menu->nama_menu . ' sedang tidak tersedia.'
                        );
                    }

                    $jumlah = (int) $item['jumlah'];

                    if ($menu->stok < $jumlah) {
                        throw new \DomainException(
                            'Stok ' . $menu->nama_menu .
                            ' tidak mencukupi. Stok tersedia: ' .
                            $menu->stok
                        );
                    }

                    $harga = (float) $menu->harga;

                    $subtotal += $harga * $jumlah;

                    $daftarMenu[] = [
                        'menu' => $menu,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $harga * $jumlah,
                    ];
                }

                /*
                 * Hitung pajak dan total.
                 */
                $subtotal = round($subtotal, 2);
                $pajak = round($subtotal * 0.10, 2);
                $total = $subtotal + $pajak;

                /*
                 * Buat nomor pesanan unik.
                 */
                do {
                    $nomorPesanan =
                        'SC' .
                        now()->format('ymdHis') .
                        random_int(10, 99);

                } while (
                    Pesanan::where(
                        'nomor_pesanan',
                        $nomorPesanan
                    )->exists()
                );

                /*
                 * SIMPAN PESANAN
                 */
                $pesanan = Pesanan::create([
                    'nomor_pesanan' => $nomorPesanan,
                    'pelanggan_id' => $pelangganId,
                    'kasir_id' => null,
                    'subtotal' => $subtotal,
                    'pajak' => $pajak,
                    'total' => $total,
                    'status' => 'Menunggu',
                ]);

                /*
                 * SIMPAN DETAIL PESANAN
                 * DAN KURANGI STOK MENU
                 */
                foreach ($daftarMenu as $item) {

                    DetailPesanan::create([
                        'pesanan_id' => $pesanan->pesanan_id,
                        'menu_id' => $item['menu']->menu_id,
                        'jumlah' => $item['jumlah'],
                        'harga' => $item['harga'],
                        'subtotal' => $item['subtotal'],
                        'catatan' => null,
                    ]);

                    $menu = $item['menu'];

                    $stokBaru =
                        $menu->stok - $item['jumlah'];

                    $menu->stok = $stokBaru;

                    $menu->terjual =
                        (int) $menu->terjual + $item['jumlah'];

                    if ($stokBaru <= 0) {
                        $menu->status = 'habis';
                    }

                    $menu->save();
                }

                /*
                 * SIMPAN PEMBAYARAN
                 */
                Pembayaran::create([
                    'pesanan_id' => $pesanan->pesanan_id,

                    // Sesuaikan nilai dengan enum database.
                    'metode' => $request->payment_method === 'qris'
                        ? 'QRIS'
                        : 'Tunai',

                    'jumlah_bayar' => $total,
                    'kembalian' => 0,
                    'status' => 'Menunggu',
                    'tanggal_bayar' => null,
                ]);

                /*
                 * CATAT RIWAYAT STATUS AWAL
                 */
                DB::table('riwayat_status')->insert([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'user_id' => null,
                    'status' => 'Menunggu',
                    'keterangan' => 'Pesanan dibuat oleh pelanggan.',
                    'waktu' => now(),
                ]);

                return $pesanan->pesanan_id;
            });

            /*
             * Keranjang hanya dikosongkan
             * setelah transaksi berhasil disimpan.
             */
            session()->forget('keranjang');

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil disimpan.',
                'redirect' => route(
                    'pesanan.rincian',
                    ['id' => $pesananId]
                ),
            ]);

        } catch (\DomainException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Pesanan belum berhasil disimpan. Silakan coba kembali.'
            ], 500);
        }
    }


    /**
     * =========================================================
     * HALAMAN RINCIAN PESANAN PELANGGAN
     * =========================================================
     */
    public function rincian($id)
    {
        $pelangganId = session('pelanggan_id');

        if (!$pelangganId) {
            return redirect()
                ->route('pelanggan.index')
                ->with('error', 'Silakan isi data pelanggan terlebih dahulu.');
        }

        $pesanan = Pesanan::with([
            'pelanggan',
            'detailPesanan.menu',
            'pembayaran',
        ])
        ->where('pesanan_id', $id)
        ->where('pelanggan_id', $pelangganId)
        ->firstOrFail();

        return view(
            'pesanan.rincian',
            compact('pesanan')
        );
    }


    /**
     * =========================================================
     * UPDATE JUMLAH ITEM
     * =========================================================
     */
    public function updateKeranjang(Request $request)
    {
        $keranjang = session('keranjang', []);

        $index = $request->index;
        $action = $request->action;

        if (!isset($keranjang[$index])) {
            return response()->json([
                'success' => false
            ]);
        }

        if ($action === 'plus') {

            $menu = Menu::find($keranjang[$index]['menu_id']);

            if (
                !$menu ||
                $menu->status !== 'tersedia' ||
                $keranjang[$index]['jumlah'] >= $menu->stok
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok menu tidak mencukupi.'
                ], 422);
            }

            $keranjang[$index]['jumlah']++;
        }

        if ($action === 'minus') {

            $keranjang[$index]['jumlah']--;

            if ($keranjang[$index]['jumlah'] <= 0) {
                unset($keranjang[$index]);

                $keranjang = array_values($keranjang);
            }
        }

        session([
            'keranjang' => $keranjang
        ]);

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * =========================================================
     * KOSONGKAN KERANJANG
     * =========================================================
     */
    public function kosongkanKeranjang()
    {
        session()->forget('keranjang');

        return response()->json([
            'success' => true
        ]);
    }
}