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
}
