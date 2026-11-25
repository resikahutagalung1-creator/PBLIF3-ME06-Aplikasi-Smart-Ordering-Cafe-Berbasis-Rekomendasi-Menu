<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Meja;
use App\Models\Menu;
use App\Models\Kategori;

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

    // Menampilkan halaman kelola menu
public function kelolaMenu()
{
    $menus = Menu::with('kategori')
        ->whereIn('status', ['tersedia', 'habis'])
        ->whereHas('kategori', function ($query) {
            $query->where('status', 'aktif');
        })
        ->orderBy('menu_id')
        ->get();

    return view('admin.menu', compact('menus'));
}

    // Menampilkan menu yang dinonaktifkan
public function kelolaMenuNonaktif()
{
    $menus = Menu::with('kategori')
        ->where('status', 'nonaktif')
        ->orderBy('menu_id')
        ->get();

    return view('admin.menu-nonaktif', compact('menus'));
}

    // Menampilkan form tambah menu
    public function tambahMenu()
{
    $kategoris = Kategori::where('status', 'aktif')
        ->orderBy('kategori_id')
        ->get();

    return view('admin.menu-tambah', compact('kategoris'));
}

    public function simpanMenu(Request $request)
{
    $request->validate([
        'nama_menu' => 'required|string|max:255',
        'kategori_id' => 'required',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status' => 'required|in:tersedia,habis',
    ]);

    $file = $request->file('gambar');

    $namaFile = time() . '_' . $file->getClientOriginalName();

    $file->move(public_path('images/menu'), $namaFile);

    Menu::create([
        'nama_menu' => $request->nama_menu,
        'kategori_id' => $request->kategori_id,
        'deskripsi' => $request->deskripsi,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'gambar' => $namaFile,
        'status' => $request->status,
        'terjual' => 0,
    ]);

    return redirect()->route('admin.menu')
        ->with('success', 'Menu berhasil ditambahkan!');
}

// Menampilkan form edit menu
public function editMenu($id)
{
    $menu = Menu::findOrFail($id);

    $kategoris = Kategori::where('status', 'aktif')
        ->orderBy('kategori_id')
        ->get();

    return view('admin.menu-edit', compact('menu', 'kategoris'));
}

    // Menyimpan perubahan menu
public function updateMenu(Request $request, $id)
{
    $menu = Menu::findOrFail($id);

    $request->validate([
        'nama_menu' => 'required|string|max:255',
        'kategori_id' => 'required',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'status' => 'required|in:tersedia,habis',
    ]);

    // Jika admin upload gambar baru
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');

        $namaFile = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('images/menu'), $namaFile);

        $menu->gambar = $namaFile;
    }

    // Update data menu
    $menu->nama_menu = $request->nama_menu;
    $menu->kategori_id = $request->kategori_id;
    $menu->deskripsi = $request->deskripsi;
    $menu->harga = $request->harga;
    $menu->stok = $request->stok;
    $menu->status = $request->status;

    $menu->save();

    return redirect()->route('admin.menu')
        ->with('success', 'Menu berhasil diperbarui!');
}

// Menonaktifkan menu
public function nonaktifMenu($id)
{
    $menu = Menu::findOrFail($id);

    $menu->status = 'nonaktif';
    $menu->save();

    return redirect()
        ->route('admin.menu.nonaktif.list')
        ->with('success', 'Menu berhasil dinonaktifkan.');
}

// Mengaktifkan kembali menu
public function aktifMenu($id)
{
    $menu = Menu::findOrFail($id);

    $menu->status = 'tersedia';
    $menu->save();

    return redirect()
        ->route('admin.menu')
        ->with('success', 'Menu berhasil diaktifkan kembali.');
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

   
    // Menampilkan daftar pengguna
    public function kelolaPengguna()
    {
        $penggunas = User::orderBy('user_id', 'desc')->get();

        return view('admin.pengguna', compact('penggunas'));
    }

    // Menampilkan form tambah pengguna
    public function tambahPengguna()
    {
        return view('admin.pengguna-tambah');
    }

    // Menyimpan pengguna baru
    public function simpanPengguna(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,kasir',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.pengguna')
            ->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    // Menampilkan form edit pengguna
    public function editPengguna($id)
    {
        $pengguna = User::findOrFail($id);

        // Admin Utama tidak boleh diedit
        if ($pengguna->username === 'adminsmart') {
            return redirect()->route('admin.pengguna')
                ->with('error', 'Akun Admin Utama tidak boleh diedit.');
        }

        return view('admin.pengguna-edit', compact('pengguna'));
    }

    // Menyimpan perubahan pengguna
    public function updatePengguna(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        // Lindungi Admin Utama
        if ($pengguna->username === 'adminsmart') {
            return redirect()->route('admin.pengguna')
                ->with('error', 'Akun Admin Utama tidak boleh diedit.');
        }

        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username,' . $id . ',user_id',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,kasir',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $pengguna->nama = $request->nama;
        $pengguna->username = $request->username;
        $pengguna->role = $request->role;
        $pengguna->status = $request->status;

        if ($request->filled('password')) {
            $pengguna->password = $request->password;
        }

        $pengguna->save();

        return redirect()->route('admin.pengguna')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // Mengaktifkan dan menonaktifkan pengguna
    public function ubahStatusPengguna($id)
    {
        $pengguna = User::findOrFail($id);

        // Admin Utama tidak boleh dinonaktifkan
        if ($pengguna->username === 'adminsmart') {
            return redirect()->route('admin.pengguna')
                ->with('error', 'Akun Admin Utama tidak boleh dinonaktifkan.');
        }

        // Tidak boleh menonaktifkan akun sendiri
        if ((int) $pengguna->user_id === (int) session('admin_id')) {
            return redirect()->route('admin.pengguna')
                ->with('error', 'Kamu tidak bisa menonaktifkan akun sendiri.');
        }

        // Mencegah tidak adanya Admin aktif
        if ($pengguna->role === 'admin' && $pengguna->status === 'aktif') {
            $jumlahAdminAktif = User::where('role', 'admin')
                ->where('status', 'aktif')
                ->count();

            if ($jumlahAdminAktif <= 1) {
                return redirect()->route('admin.pengguna')
                    ->with('error', 'Minimal harus ada satu Admin aktif.');
            }
        }

        $pengguna->status = $pengguna->status === 'aktif'
            ? 'nonaktif'
            : 'aktif';

        $pengguna->save();

        return redirect()->route('admin.pengguna')
            ->with('success', 'Status pengguna berhasil diperbarui.');
    }

    // Menghapus pengguna
    public function hapusPengguna($id)
    {
        $pengguna = User::findOrFail($id);

        // Admin Utama tidak boleh dihapus
        if ($pengguna->username === 'adminsmart') {
            return redirect()->route('admin.pengguna')
                ->with('error', 'Akun Admin Utama tidak boleh dihapus.');
        }

        // Tidak boleh menghapus akun sendiri
        if ((int) $pengguna->user_id === (int) session('admin_id')) {
            return redirect()->route('admin.pengguna')
                ->with('error', ' tidak bisa menghapus akun sendiri.');
        }

        // Mencegah tidak adanya Admin aktif
        if ($pengguna->role === 'admin' && $pengguna->status === 'aktif') {
            $jumlahAdminAktif = User::where('role', 'admin')
                ->where('status', 'aktif')
                ->count();

            if ($jumlahAdminAktif <= 1) {
                return redirect()->route('admin.pengguna')
                    ->with('error', 'Admin aktif terakhir tidak boleh dihapus.');
            }
        }

        $pengguna->delete();

        return redirect()->route('admin.pengguna')
            ->with('success', 'Data pengguna berhasil dihapus.');
    }

}