<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Kategori;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN MENU
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Ambil kategori yang aktif
        $kategoris = Kategori::where('status', 'aktif')
            ->orderBy('kategori_id')
            ->get();

        // Ambil menu yang masih ditampilkan kepada pelanggan
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

            $query->where('nama_menu', 'like', '%' . $search . '%');
        }

        // Ambil daftar menu
        $menus = $query
            ->orderBy('menu_id')
            ->get();

        return view('menu', compact('menus', 'kategoris'));
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL MENU
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        // Cari menu yang tidak berstatus nonaktif
        $menu = Menu::with('kategori')
            ->where('menu_id', $id)
            ->whereIn('status', ['tersedia', 'habis'])
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            })
            ->firstOrFail();

        // Ambil rekomendasi dari kategori yang sama
        $rekomendasi = Menu::with('kategori')
            ->where('kategori_id', $menu->kategori_id)
            ->where('menu_id', '!=', $menu->menu_id)
            ->where('status', 'tersedia')
            ->where('stok', '>', 0)
            ->whereHas('kategori', function ($q) {
                $q->where('status', 'aktif');
            })
            ->orderBy('menu_id')
            ->limit(3)
            ->get();

        return view('menu-detail', compact('menu', 'rekomendasi'));
    }
}