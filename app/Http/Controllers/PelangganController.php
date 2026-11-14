<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Meja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PelangganController extends Controller
{
    public function index()
    {
        $mejas = Meja::where('status', 'tersedia')
            ->orderBy('nomor_meja')
            ->get();

        return view('pelanggan', compact('mejas'));
    }

    public function mulai(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nomor_meja' => 'required|string|exists:meja,nomor_meja',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_meja.required' => 'Nomor meja wajib dipilih.',
            'nomor_meja.exists' => 'Nomor meja tidak ditemukan.',
        ]);

        // Kunci meja dan simpan pelanggan dalam satu transaksi
        $pelanggan = DB::transaction(function () use ($request) {

            $meja = Meja::where(
                'nomor_meja',
                $request->nomor_meja
            )->lockForUpdate()->first();

            if (!$meja || $meja->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'nomor_meja' => 'Maaf, meja sudah dipesan. Silakan pilih meja lain.',
                ]);
            }

            $pelanggan = Pelanggan::create([
                'nama' => $request->nama,
                'nomor_meja' => $meja->nomor_meja,
            ]);

            // Tandai meja sebagai dipesan
            $meja->update([
                'status' => 'dipesan',
            ]);

            return $pelanggan;
        });

        // Bersihkan keranjang pelanggan sebelumnya
        session()->forget('keranjang');

        // Simpan identitas pelanggan baru
        session([
            'pelanggan_id' => $pelanggan->pelanggan_id,
            'nama_pelanggan' => $pelanggan->nama,
            'nomor_meja' => $pelanggan->nomor_meja,
        ]);

        return redirect()->route('menu.index');
    }
}