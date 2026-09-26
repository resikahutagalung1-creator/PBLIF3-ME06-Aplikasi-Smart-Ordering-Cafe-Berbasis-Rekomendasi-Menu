<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        return view('pelanggan');
    }

    public function mulai(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nomor_meja' => 'required|string|in:' .
                implode(',', [
                    'A01',
                    'A02',
                    'A03',
                    'A04',
                    'A05',
                    'A06',
                    'A07',
                    'A08',
                    'A09',
                    'A10',
                    'A11',
                    'A12',
                    'A13',
                    'A14',
                    'A15',
                    'A16',
                    'A17',
                    'A18',
                    'A19',
                    'A20',
                    'A21',
                    'A22',
                    'A23',
                    'A24',
                    'A25',
                ]),
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'nomor_meja.required' => 'Nomor meja wajib dipilih.',
            'nomor_meja.in' => 'Nomor meja tidak valid.',
        ]);

        // Simpan data pelanggan dan nomor meja
        // berdasarkan pilihan pelanggan
        $pelanggan = Pelanggan::create([
            'nama' => $request->nama,
            'nomor_meja' => $request->nomor_meja,
        ]);

        // Simpan data pelanggan ke session
        session([
            'pelanggan_id' => $pelanggan->pelanggan_id,
            'nama_pelanggan' => $pelanggan->nama,
            'nomor_meja' => $pelanggan->nomor_meja,
        ]);

        // Masuk ke halaman menu
        return redirect()->route('menu.index');
    }
}