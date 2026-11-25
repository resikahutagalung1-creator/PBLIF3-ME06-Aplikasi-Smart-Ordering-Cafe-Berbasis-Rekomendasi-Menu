<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori aktif
        $kategoris = Kategori::where('status', 'aktif')
            ->orderBy('kategori_id')
            ->get();

        // Query daftar menu
        $query = Menu::with('kategori')
            ->whereIn('status', ['tersedia', 'habis'])
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            });

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Pencarian menu
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(
                'nama_menu',
                'like',
                '%' . $search . '%'
            );
        }

        // Daftar menu
        $menus = $query
            ->orderBy('menu_id')
            ->get();

        // Rekomendasi 5 menu terpopuler
        $rekomendasi = Menu::with('kategori')
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->where('terjual', '>', 0)
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            })
            ->orderByDesc('terjual')
            ->orderBy('menu_id')
            ->limit(5)
            ->get();

        return view(
            'menu',
            compact('menus', 'kategoris', 'rekomendasi')
        );
    }

    public function show($id)
    {
        // Ambil detail menu
        $menu = Menu::with('kategori')
            ->where('menu_id', $id)
            ->whereIn('status', ['tersedia', 'habis'])
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            })
            ->firstOrFail();

        // Rekomendasi dari kategori yang sama
        $rekomendasi = Menu::with('kategori')
            ->where('kategori_id', $menu->kategori_id)
            ->where('menu_id', '!=', $menu->menu_id)
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->where('terjual', '>', 0)
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            })
            ->orderByDesc('terjual')
            ->orderBy('menu_id')
            ->limit(3)
            ->get();

        return view(
            'menu-detail',
            compact('menu', 'rekomendasi')
        );
    }

    // Menampilkan daftar menu khusus Admin
public function adminIndex()
{
    $menus = Menu::with('kategori')
        ->whereIn('status', ['tersedia', 'habis'])
        ->orderBy('menu_id', 'desc')
        ->get();

    return view('admin.menu.index', compact('menus'));
}

    // Menampilkan form tambah menu
    public function create()
    {
        $kategoris = Kategori::where('status', 'aktif')
            ->orderBy('kategori_id')
            ->get();

        return view('admin.menu.create', compact('kategoris'));
    }

    // Menyimpan menu baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori,kategori_id',
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:tersedia,habis,nonaktif',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('menu', 'public');
        }

        $data['terjual'] = 0;

        Menu::create($data);

        return redirect()
            ->route('admin.menu')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    // Menampilkan form edit menu
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        $kategoris = Kategori::where('status', 'aktif')
            ->orderBy('kategori_id')
            ->get();

        return view('admin.menu.edit', compact('menu', 'kategoris'));
    }

    // Memperbarui menu
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori,kategori_id',
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:tersedia,habis,nonaktif',
        ]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')
                ->store('menu', 'public');
        }

        $menu->update($data);

        return redirect()
            ->route('admin.menu')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    // Menghapus menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->delete();

        return redirect()
            ->route('admin.menu')
            ->with('success', 'Menu berhasil dihapus.');
    }

}
