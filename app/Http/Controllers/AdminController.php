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
}