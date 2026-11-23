<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Menu;
use App\Models\Pelanggan;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;

class PesananController extends Controller
{
    /**
     * TAMBAH MENU KE KERANJANG
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

        if ($menu->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Stok menu sudah habis.'
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

        session(['keranjang' => $keranjang]);

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
     * HALAMAN RINGKASAN PESANAN
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
     * HALAMAN PEMBAYARAN
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
     * KONFIRMASI DAN SIMPAN PESANAN
     */
    public function konfirmasi(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:qris,tunai',
        ]);

        $paymentMethod = $request->payment_method;
        $keranjang = session('keranjang', []);

        if (empty($keranjang)) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang masih kosong.'
            ], 422);
        }

        $pelangganId = session('pelanggan_id');

        $pelanggan = Pelanggan::where(
            'pelanggan_id',
            $pelangganId
        )->first();

        if (!$pelanggan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelanggan tidak ditemukan. Silakan isi data pelanggan kembali.'
            ], 422);
        }

        if (
            $paymentMethod === 'qris' &&
            empty(config('midtrans.server_key'))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Server Key Midtrans belum dikonfigurasi.'
            ], 500);
        }

        try {

            /*
             * SIMPAN PESANAN, DETAIL, DAN PEMBAYARAN
             */
            $dataPesanan = DB::transaction(function () use (
                $keranjang,
                $pelangganId,
                $paymentMethod
            ) {

                $daftarMenu = [];
                $subtotal = 0;

                // Periksa menu dan stok terbaru
                foreach ($keranjang as $item) {

                    if (
                        empty($item['menu_id']) ||
                        !isset($item['jumlah']) ||
                        (int) $item['jumlah'] <= 0
                    ) {
                        throw new \DomainException(
                            'Data keranjang tidak valid.'
                        );
                    }

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
                            'Menu ' . $menu->nama_menu .
                            ' sedang tidak tersedia.'
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
                    $subtotalItem = $harga * $jumlah;

                    $subtotal += $subtotalItem;

                    $daftarMenu[] = [
                        'menu' => $menu,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $subtotalItem,
                    ];
                }

                // Hitung subtotal, pajak, dan total
                $subtotal = round($subtotal, 2);
                $pajak = round($subtotal * 0.10, 2);
                $total = round($subtotal + $pajak, 2);

                /*
                 * QRIS menggunakan nominal rupiah bulat.
                 * Nominal yang disimpan pada pembayaran harus
                 * sama dengan nominal yang dikirim ke Midtrans.
                 */
                $jumlahBayar = $paymentMethod === 'qris'
                    ? (int) round($total)
                    : $total;

                // Buat nomor pesanan unik
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

                // Simpan pesanan
                $pesanan = Pesanan::create([
                    'nomor_pesanan' => $nomorPesanan,
                    'pelanggan_id' => $pelangganId,
                    'kasir_id' => null,
                    'subtotal' => $subtotal,
                    'pajak' => $pajak,
                    'total' => $total,
                    'status' => 'Menunggu',
                ]);

                // Simpan detail dan kurangi stok
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

                    $menu->stok -= $item['jumlah'];

                    // Untuk Tunai, perilaku lama tetap dipertahankan.
                    // Untuk QRIS, jumlah terjual menunggu pembayaran berhasil.
                    if ($paymentMethod === 'tunai') {
                        $menu->terjual =
                            (int) $menu->terjual + $item['jumlah'];
                    }

                    if ($menu->stok <= 0) {
                        $menu->status = 'habis';
                    }

                    $menu->save();
                }

                // Simpan pembayaran
                $pembayaran = Pembayaran::create([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'metode' => $paymentMethod === 'qris'
                        ? 'QRIS'
                        : 'Tunai',
                    'jumlah_bayar' => $jumlahBayar,
                    'kembalian' => 0,
                    'status' => 'Menunggu',
                    'tanggal_bayar' => null,
                    'midtrans_order_id' => $paymentMethod === 'qris'
                        ? $nomorPesanan
                        : null,
                ]);

                // Catat riwayat status awal
                DB::table('riwayat_status')->insert([
                    'pesanan_id' => $pesanan->pesanan_id,
                    'user_id' => null,
                    'status' => 'Menunggu',
                    'keterangan' => 'Pesanan dibuat oleh pelanggan.',
                    'waktu' => now(),
                ]);

                return [
                    'pesanan_id' => $pesanan->pesanan_id,
                    'pembayaran_id' => $pembayaran->pembayaran_id,
                    'nomor_pesanan' => $nomorPesanan,
                    'total' => $total,
                    'jumlah_bayar' => $jumlahBayar,
                ];
            });


            /*
             * PEMBAYARAN TUNAI
             * TETAP MENGGUNAKAN ALUR LAMA
             */
            if ($paymentMethod === 'tunai') {

                session()->forget('keranjang');

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil disimpan.',
                    'redirect' => route(
                        'pesanan.rincian',
                        ['id' => $dataPesanan['pesanan_id']]
                    ),
                ]);
            }


            /*
             * PEMBAYARAN QRIS MELALUI MIDTRANS
             */
            $serverKey = config('midtrans.server_key');

            $isProduction = config('midtrans.is_production');

            $url = $isProduction
                ? 'https://api.midtrans.com/v2/charge'
                : 'https://api.sandbox.midtrans.com/v2/charge';

            $response = Http::withBasicAuth(
                $serverKey,
                ''
            )
            ->acceptJson()
            ->timeout(30)
            ->post($url, [
                'payment_type' => 'qris',

                'transaction_details' => [
                    'order_id' => $dataPesanan['nomor_pesanan'],
                    'gross_amount' => $dataPesanan['jumlah_bayar'],
                ],

                'qris' => [
                    'acquirer' => 'gopay',
                ],
            ]);

            /*
             * Jika Midtrans menolak transaksi dengan respons 4xx,
             * batalkan pesanan dan kembalikan stok.
             *
             * Jika terjadi 5xx, transaksi mungkin sudah diterima
             * tetapi responsnya bermasalah. Karena itu stok tidak
             * langsung dikembalikan.
             */
            if (!$response->successful()) {

                if (
                    $response->status() >= 400 &&
                    $response->status() < 500
                ) {
                    $this->batalkanPesananQris(
                        $dataPesanan['pesanan_id'],
                        'Pembuatan transaksi QRIS ditolak oleh Midtrans.'
                    );
                }

                report(new \RuntimeException(
                    'Midtrans error: ' . $response->body()
                ));

                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi QRIS belum berhasil dibuat. Silakan periksa status pesanan sebelum mencoba kembali.'
                ], 502);
            }

            $hasilMidtrans = $response->json();

            // Cari URL QR Code dari respons Midtrans
            $qrAction = collect(
                $hasilMidtrans['actions'] ?? []
            )->first(function ($action) {
                return in_array(
                    $action['name'] ?? '',
                    [
                        'generate-qr-code',
                        'generate-qr-code-v2'
                    ],
                    true
                );
            });

            $qrUrl = $qrAction['url'] ?? null;

            if (!$qrUrl) {

                report(new \RuntimeException(
                    'URL QR Code tidak ditemukan pada respons Midtrans.'
                ));

                return response()->json([
                    'success' => false,
                    'message' => 'Transaksi telah dikirim, tetapi QR Code belum berhasil diperoleh. Jangan mengulangi pembayaran sebelum status transaksi diperiksa.'
                ], 502);
            }

            // Simpan data transaksi Midtrans
            Pembayaran::where(
                'pembayaran_id',
                $dataPesanan['pembayaran_id']
            )->update([
                'midtrans_transaction_id' =>
                    $hasilMidtrans['transaction_id'] ?? null,

                'qris_url' => $qrUrl,

                'qris_string' =>
                    $hasilMidtrans['qr_string'] ?? null,

                'expired_at' => !empty($hasilMidtrans['expiry_time'])
                    ? \Carbon\Carbon::parse(
                        $hasilMidtrans['expiry_time']
                    )
                    : null,
            ]);

            // Kosongkan keranjang setelah QR berhasil dibuat
            session()->forget('keranjang');

            return response()->json([
                'success' => true,
                'message' => 'QRIS berhasil dibuat.',
                'payment_pending' => true,
                'qr_url' => $qrUrl,
                'qr_string' => $hasilMidtrans['qr_string'] ?? null,
                'order_number' => $dataPesanan['nomor_pesanan'],
                'pesanan_id' => $dataPesanan['pesanan_id'],
                'total' => $dataPesanan['jumlah_bayar'],
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
                'message' => 'Pesanan gagal diproses. Silakan periksa status pesanan sebelum mencoba kembali.'
            ], 500);
        }
    }


    /**
     * MEMBATALKAN PESANAN QRIS DAN MENGEMBALIKAN STOK
     */
    private function batalkanPesananQris(
        $pesananId,
        $keterangan = 'Pembayaran QRIS gagal atau kedaluwarsa.'
    ) {
        return DB::transaction(function () use (
            $pesananId,
            $keterangan
        ) {

            $pembayaran = Pembayaran::where(
                'pesanan_id',
                $pesananId
            )->lockForUpdate()->first();

            if (
                !$pembayaran ||
                $pembayaran->metode !== 'QRIS' ||
                $pembayaran->status !== 'Menunggu'
            ) {
                return false;
            }

            $pesanan = Pesanan::where(
                'pesanan_id',
                $pesananId
            )->lockForUpdate()->first();

            if (!$pesanan) {
                return false;
            }

            // Kembalikan stok
            $detailPesanan = DetailPesanan::where(
                'pesanan_id',
                $pesananId
            )->get();

            foreach ($detailPesanan as $detail) {

                $menu = Menu::where(
                    'menu_id',
                    $detail->menu_id
                )->lockForUpdate()->first();

                if ($menu) {
                    $menu->stok += $detail->jumlah;

                    if (
                        $menu->status === 'habis' &&
                        $menu->stok > 0
                    ) {
                        $menu->status = 'tersedia';
                    }

                    $menu->save();
                }
            }

            $pembayaran->status = 'Gagal';
            $pembayaran->save();

            $pesanan->status = 'Dibatalkan';
            $pesanan->save();

            DB::table('riwayat_status')->insert([
                'pesanan_id' => $pesananId,
                'user_id' => null,
                'status' => 'Dibatalkan',
                'keterangan' => $keterangan,
                'waktu' => now(),
            ]);

            return true;
        });
    }


    /**
     * MENERIMA DAN MEMVERIFIKASI NOTIFIKASI MIDTRANS
     */
    public function midtransNotification(Request $request)
    {
        try {

            $serverKey = config('midtrans.server_key');

            $orderId = $request->input('order_id');
            $statusCode = $request->input('status_code');
            $grossAmount = $request->input('gross_amount');
            $signatureKey = $request->input('signature_key');

            if (
                !$serverKey ||
                !$orderId ||
                !$statusCode ||
                !$grossAmount ||
                !$signatureKey
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data notifikasi tidak lengkap.'
                ], 400);
            }

            // Verifikasi signature menggunakan nilai asli dari Midtrans
            $expectedSignature = hash(
                'sha512',
                $orderId .
                $statusCode .
                $grossAmount .
                $serverKey
            );

            \Log::info('Pemeriksaan Signature Midtrans', [
    'order_id' => $orderId,
    'status_code' => $statusCode,
    'gross_amount' => $grossAmount,
    'signature_cocok' => hash_equals(
        $expectedSignature,
        $signatureKey
    ),
]);

if (!hash_equals($expectedSignature, $signatureKey)) {
    return response()->json([
        'success' => false,
        'message' => 'Signature tidak valid.'
    ], 403);
}

            if ($request->input('payment_type') !== 'qris') {
                return response()->json([
                    'success' => false,
                    'message' => 'Metode pembayaran tidak sesuai.'
                ], 422);
            }

            DB::transaction(function () use (
                $request,
                $orderId,
                $grossAmount
            ) {

                $pembayaran = Pembayaran::where(
                    'midtrans_order_id',
                    $orderId
                )->lockForUpdate()->first();

                if (!$pembayaran) {
                    throw new \RuntimeException(
                        'Data pembayaran tidak ditemukan.'
                    );
                }

                // Cocokkan nominal notifikasi dengan database
                $nominalNotifikasi = number_format(
                    (float) $grossAmount,
                    2,
                    '.',
                    ''
                );

                $nominalDatabase = number_format(
                    (float) $pembayaran->jumlah_bayar,
                    2,
                    '.',
                    ''
                );

                if ($nominalNotifikasi !== $nominalDatabase) {
                    throw new \RuntimeException(
                        'Nominal pembayaran tidak sesuai.'
                    );
                }

                $pesanan = Pesanan::where(
                    'pesanan_id',
                    $pembayaran->pesanan_id
                )->lockForUpdate()->first();

                if (!$pesanan) {
                    throw new \RuntimeException(
                        'Data pesanan tidak ditemukan.'
                    );
                }

                $transactionStatus = $request->input(
                    'transaction_status'
                );

                $fraudStatus = $request->input('fraud_status');

                // Simpan ID transaksi Midtrans jika tersedia
                $pembayaran->midtrans_transaction_id =
                    $request->input('transaction_id')
                    ?? $pembayaran->midtrans_transaction_id;

                /*
                 * PEMBAYARAN BERHASIL
                 */
                if (
                    $transactionStatus === 'settlement' ||
                    (
                        $transactionStatus === 'capture' &&
                        $fraudStatus === 'accept'
                    )
                ) {

                    /*
                     * Hanya proses jika status masih Menunggu.
                     * Ini mencegah jumlah terjual bertambah
                     * berulang kali akibat notifikasi duplikat.
                     */
                    if ($pembayaran->status === 'Menunggu') {

                        $detailPesanan = DetailPesanan::where(
                            'pesanan_id',
                            $pesanan->pesanan_id
                        )->get();

                        foreach ($detailPesanan as $detail) {

                            $menu = Menu::where(
                                'menu_id',
                                $detail->menu_id
                            )->lockForUpdate()->first();

                            if ($menu) {
                                $menu->terjual =
                                    (int) $menu->terjual +
                                    (int) $detail->jumlah;

                                $menu->save();
                            }
                        }

                        $pembayaran->status = 'Berhasil';
                        $pembayaran->tanggal_bayar = now();

                        $pembayaran->save();
                    }

                /*
                 * PEMBAYARAN GAGAL / KEDALUWARSA
                 */
                } elseif (in_array($transactionStatus, [
                    'deny',
                    'cancel',
                    'expire',
                    'failure'
                ], true)) {

                    if ($pembayaran->status === 'Menunggu') {

                        // Simpan ID transaksi terlebih dahulu
                        $pembayaran->save();

                        // Batalkan pesanan dan kembalikan stok
                        $this->batalkanPesananQris(
                            $pesanan->pesanan_id,
                            'Pembayaran QRIS ' .
                            $transactionStatus .
                            ' dari Midtrans.'
                        );
                    } else {
                        $pembayaran->save();
                    }

                } else {
                    // Status pending: tetap menunggu pembayaran
                    $pembayaran->save();
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi Midtrans berhasil diproses.'
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Notifikasi Midtrans gagal diproses.'
            ], 500);
        }
    }


    /**
     * HALAMAN RINCIAN PESANAN PELANGGAN
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
     * UPDATE JUMLAH ITEM DI KERANJANG
     */
    public function updateKeranjang(Request $request)
    {
        $keranjang = session('keranjang', []);

        $index = $request->index;
        $action = $request->action;

        if (!isset($keranjang[$index])) {
            return response()->json([
                'success' => false,
                'message' => 'Item keranjang tidak ditemukan.'
            ], 404);
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

        } elseif ($action === 'minus') {

            $keranjang[$index]['jumlah']--;

            if ($keranjang[$index]['jumlah'] <= 0) {
                unset($keranjang[$index]);

                $keranjang = array_values($keranjang);
            }

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Aksi tidak valid.'
            ], 422);
        }

        session([
            'keranjang' => $keranjang
        ]);

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * KOSONGKAN KERANJANG
     */
    public function kosongkanKeranjang()
    {
        session()->forget('keranjang');

        return response()->json([
            'success' => true
        ]);
    }
    
/**
 * CEK STATUS PEMBAYARAN QRIS OTOMATIS
 */
public function cekStatusPembayaran($id)
{
    $pelangganId = session('pelanggan_id');

    if (!$pelangganId) {
        return response()->json([
            'success' => false,
            'message' => 'Sesi pelanggan tidak ditemukan.'
        ], 403);
    }

    // Cari pesanan berdasarkan primary key pesanan_id
    $pesanan = Pesanan::where('pesanan_id', $id)
        ->where('pelanggan_id', $pelangganId)
        ->first();

    if (!$pesanan) {
        return response()->json([
            'success' => false,
            'message' => 'Pesanan tidak ditemukan.'
        ], 404);
    }

    $pembayaran = Pembayaran::where(
        'pesanan_id',
        $pesanan->pesanan_id
    )->first();

    if (!$pembayaran || !$pembayaran->midtrans_order_id) {
        return response()->json([
            'success' => false,
            'message' => 'Data pembayaran QRIS tidak ditemukan.'
        ], 404);
    }

    // Jika sudah berhasil, langsung arahkan ke rincian pesanan
    if ($pembayaran->status === 'Berhasil') {
        return response()->json([
            'success' => true,
            'payment_status' => 'Berhasil',
            'redirect' => route('pesanan.rincian', [
                'id' => $pesanan->pesanan_id
            ])
        ]);
    }

    if (
        $pembayaran->status === 'Gagal' ||
        $pesanan->status === 'Dibatalkan'
    ) {
        return response()->json([
            'success' => true,
            'payment_status' => 'Gagal',
            'message' => 'Pembayaran gagal atau pesanan dibatalkan.'
        ]);
    }

    $serverKey = config('midtrans.server_key');

    $baseUrl = config('midtrans.is_production')
        ? 'https://api.midtrans.com'
        : 'https://api.sandbox.midtrans.com';

    try {
        // Meminta status transaksi langsung ke Midtrans
        $response = Http::withBasicAuth($serverKey, '')
            ->acceptJson()
            ->timeout(15)
            ->get(
                $baseUrl . '/v2/' .
                urlencode($pembayaran->midtrans_order_id) .
                '/status'
            );

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
                'message' => 'Status pembayaran belum dapat diperiksa.'
            ], 503);
        }

        $data = $response->json();

        // Cocokkan nomor transaksi
        if (
            ($data['order_id'] ?? null) !==
            $pembayaran->midtrans_order_id
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor transaksi tidak sesuai.'
            ], 422);
        }

        // Cocokkan jumlah pembayaran
        if (
            abs(
                (float) ($data['gross_amount'] ?? 0) -
                (float) $pembayaran->jumlah_bayar
            ) >= 0.01
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah pembayaran tidak sesuai.'
            ], 422);
        }

        $transactionStatus = $data['transaction_status'] ?? '';
        $fraudStatus = $data['fraud_status'] ?? '';

        // Jika pembayaran berhasil
        if (
            $transactionStatus === 'settlement' ||
            (
                $transactionStatus === 'capture' &&
                $fraudStatus === 'accept'
            )
        ) {
            DB::transaction(function () use ($pesanan, $data) {

                $pembayaran = Pembayaran::where(
                    'pesanan_id',
                    $pesanan->pesanan_id
                )->lockForUpdate()->first();

                if ($pembayaran && $pembayaran->status === 'Menunggu') {

                    $pembayaran->status = 'Berhasil';
                    $pembayaran->tanggal_bayar = now();

                    $pembayaran->midtrans_transaction_id =
                        $data['transaction_id'] ?? null;

                    $pembayaran->save();

                    // Tambahkan jumlah menu terjual satu kali saja
                    $detailPesanan = DetailPesanan::where(
                        'pesanan_id',
                        $pesanan->pesanan_id
                    )->get();

                    foreach ($detailPesanan as $detail) {

                        $menu = Menu::where(
                            'menu_id',
                            $detail->menu_id
                        )->lockForUpdate()->first();

                        if ($menu) {
                            $menu->terjual =
                                (int) $menu->terjual +
                                (int) $detail->jumlah;

                            $menu->save();
                        }
                    }
                }
            });

            return response()->json([
                'success' => true,
                'payment_status' => 'Berhasil',
                'redirect' => route('pesanan.rincian', [
                    'id' => $pesanan->pesanan_id
                ])
            ]);
        }

        // Jika pembayaran gagal atau kedaluwarsa
        if (in_array($transactionStatus, [
            'deny',
            'cancel',
            'expire',
            'failure'
        ], true)) {

            $this->batalkanPesananQris(
                $pesanan->pesanan_id,
                'Pembayaran QRIS ' . $transactionStatus
            );

            return response()->json([
                'success' => true,
                'payment_status' => 'Gagal',
                'message' => 'Pembayaran gagal atau kedaluwarsa.'
            ]);
        }

        // Jika masih pending
        return response()->json([
            'success' => true,
            'payment_status' => 'Menunggu',
            'message' => 'Menunggu pembayaran QRIS.'
        ]);

    } catch (\Throwable $e) {

        \Log::error('Gagal memeriksa status pembayaran Midtrans', [
            'pesanan_id' => $id,
            'error' => $e->getMessage()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat memeriksa pembayaran.'
        ], 500);
    }
}
/**
 * Mengecek status pesanan pelanggan
 */
public function statusPesanan($id)
{
    $pelangganId = session('pelanggan_id');

    if (!$pelangganId) {
        return response()->json([
            'success' => false,
            'message' => 'Sesi pelanggan tidak ditemukan.'
        ], 403);
    }

    $pesanan = Pesanan::where('pesanan_id', $id)
        ->where('pelanggan_id', $pelangganId)
        ->first();

    if (!$pesanan) {
        return response()->json([
            'success' => false,
            'message' => 'Pesanan tidak ditemukan.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'status' => $pesanan->status
    ]);
}
public function halamanStatusPesanan($id)
{
    $pelangganId = session('pelanggan_id');

    if (!$pelangganId) {
        return redirect('/')->with('error', 'Sesi pelanggan tidak ditemukan.');
    }

    $pesanan = Pesanan::with([
        'pelanggan',
        'detailPesanan.menu',
        'pembayaran',
    ])
    ->where('pesanan_id', $id)
    ->where('pelanggan_id', $pelangganId)
    ->firstOrFail();

    return view('pesanan.status-pesanan', compact('pesanan'));
}
}