<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meja;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)
            ->where('role', 'admin')
            ->where('status', 'aktif')
            ->first();

        if (!$user || $user->password !== $request->password) {
            return back()->with(
                'error',
                'Username atau password admin salah.'
            );
        }

        session([
            'admin_login' => true,
            'admin_id' => $user->user_id,
            'admin_nama' => $user->nama,
            'admin_username' => $user->username,
            'admin_role' => $user->role,
        ]);

        return redirect('/admin/dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Menampilkan daftar meja
    public function kelolaMeja()
    {
        $mejas = Meja::orderBy('nomor_meja')->get();

        return view('admin.meja', compact('mejas'));
    }

    // Membuka kembali meja yang sudah digunakan
    public function tersediaKembali($id)
    {
        $meja = Meja::findOrFail($id);

        $meja->update([
            'status' => 'tersedia',
        ]);

        return redirect()
            ->route('admin.meja')
            ->with('success', 'Meja ' . $meja->nomor_meja . ' berhasil tersedia kembali.');
    }
}