<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

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

        if ($menu->stok <= 0) {

            return response()->json([
                'success' => false,
                'message' => 'Stok menu sedang habis.'
            ], 422);
        }

        $keranjang = session('keranjang', []);

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

            $subtotal +=
                $item['harga'] *
                $item['jumlah'];
        }

        $pajak = $subtotal * 0.10;

        $total = $subtotal + $pajak;

        return view(
            'pesanan.ringkasan',
            compact(
                'keranjang',
                'subtotal',
                'pajak',
                'total'
            )
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

        /*
         * Jika keranjang kosong,
         * kembali ke halaman menu.
         */
        if (empty($keranjang)) {

            return redirect()
                ->route('menu.index')
                ->with('error', 'Keranjang masih kosong.');
        }


        $subtotal = 0;

        foreach ($keranjang as $item) {

            $subtotal +=
                $item['harga'] *
                $item['jumlah'];
        }


        /*
         * Pajak 10%
         */
        $pajak = $subtotal * 0.10;


        /*
         * Total pembayaran
         */
        $total = $subtotal + $pajak;


        /*
         * Ambil data pelanggan dari session
         */
        $namaPelanggan =
            session('nama_pelanggan', 'Pelanggan');

        $nomorMeja =
            session('nomor_meja', '-');


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

            $keranjang[$index]['jumlah']++;
        }


        if ($action === 'minus') {

            $keranjang[$index]['jumlah']--;

            if ($keranjang[$index]['jumlah'] <= 0) {

                unset($keranjang[$index]);

                $keranjang =
                    array_values($keranjang);
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