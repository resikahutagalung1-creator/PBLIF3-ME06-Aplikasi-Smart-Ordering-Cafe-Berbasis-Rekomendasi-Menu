<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuMoqqaSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /*
             * =====================================================
             * 1. NONAKTIFKAN 24 MENU LAMA
             * Data lama tidak dihapus dan harga tidak diubah.
             * =====================================================
             */

            DB::table('menu')
                ->whereBetween('menu_id', [1, 24])
                ->update([
                    'status' => 'nonaktif',
                    'updated_at' => now(),
                ]);


            /*
             * =====================================================
             * 2. DAFTAR MENU MOQQA
             * =====================================================
             */

            $daftarMenu = [

                // COFFEE (KATEGORI ID 1)

                1 => [
                    ['Classic Coffee', 'Americano', 28000],
                    ['Classic Coffee', 'Affogato', 25000],
                    ['Classic Coffee', 'Cafe Latte', 30000],
                    ['Classic Coffee', 'Cappuccino', 30000],
                    ['Classic Coffee', 'Caramel Macchiato', 33000],
                    ['Classic Coffee', 'Espresso', 22000],
                    ['Classic Coffee', 'Flavour Latte', 33000],
                    ['Classic Coffee', 'Mochaccino', 30000],
                    ['Classic Coffee', 'Caramel', 33000],

                    ['Coffee Based', 'Kopi Susu Aren', 28000],
                    ['Coffee Based', 'Kopi Susu Caramel', 28000],
                    ['Coffee Based', 'Kopi Susu Dolce', 28000],
                    ['Coffee Based', 'Kopi Susu Pandan', 28000],
                    ['Coffee Based', 'Kopi Susu Signature', 28000],
                    ['Coffee Based', 'Kopi Susu Vanilla', 28000],

                    ['Manual Brew', 'V60', 28000],
                    ['Manual Brew', 'Japanese', 28000],
                    ['Manual Brew', 'Vietnam Drip', 25000],

                    ['Kopi Tradisional', 'Kopi O', 18000],
                    ['Kopi Tradisional', 'Kopi Susu', 20000],
                ],


                // NON COFFEE (KATEGORI ID 2)

                2 => [
                    ['Non Coffee', 'Matcha', 30000],
                    ['Non Coffee', 'Chocolate', 30000],
                    ['Non Coffee', 'Taro', 30000],
                    ['Non Coffee', 'Thai Tea', 30000],
                    ['Non Coffee', 'Susu Regal', 30000],
                    ['Non Coffee', 'Red Velvet', 30000],

                    ['Frappe', 'Chocolate Frappe', 35000],
                    ['Frappe', 'Cookies & Cream Frappe', 35000],
                    ['Frappe', 'Caramel Frappe', 35000],
                    ['Frappe', 'Matcha Frappe', 35000],
                    ['Frappe', 'Red Velvet Frappe', 35000],
                    ['Frappe', 'Taro Frappe', 35000],
                    ['Frappe', 'Lotus Frappe', 35000],

                    ['Tea', 'Lemon Tea', 20000],
                    ['Tea', 'Lychee Tea', 25000],
                    ['Tea', 'Earl Grey', 25000],
                    ['Tea', 'Peach Tea', 25000],

                    ['Juice', 'Avocado', 30000],
                    ['Juice', 'Mango', 30000],

                    ['Buttercream', 'Tiramisu', 35000],
                    ['Buttercream', 'Sea Salt', 35000],
                    ['Buttercream', 'Butterscotch', 35000],

                    ['Mocktail', 'Strawberry Coldbrew', 33000],
                    ['Mocktail', 'Sparkling Orange', 33000],
                    ['Mocktail', 'Orange Sunshine', 33000],

                    ['Yakult', 'Berry Yakult', 28000],
                    ['Yakult', 'Strawberry Yakult', 28000],
                    ['Yakult', 'Lychee Yakult', 28000],
                ],


                // SNACK (KATEGORI ID 3)

                3 => [
                    ['Snack Series', 'Chicken Pop Corn', 28000],
                    ['Snack Series', 'French Fries', 28000],
                    ['Snack Series', 'Fried Sausage', 28000],
                    ['Snack Series', 'Potato Wedges', 30000],
                    ['Snack Series', 'Lumpia', 28000],
                    ['Snack Series', 'Ubi Goreng', 25000],
                    ['Snack Series', 'MOQQA Platter', 48000],
                ],


                // MAKANAN (KATEGORI ID 4)

                4 => [
                    ['Main Course', 'Ayam Penyet', 30000],
                    ['Main Course', 'Burger Special MOQQA', 35000],
                    ['Main Course', 'Chicken Salisa', 35000],
                    ['Main Course', 'Chicken Sambal', 35000],
                    ['Main Course', 'Chicken Curry Rice', 35000],
                    ['Main Course', 'Chicken Black Pepper', 35000],
                    ['Main Course', 'Chicken Barbeque', 35000],
                    ['Main Course', 'Chicken Teriyaki', 35000],
                    ['Main Course', 'Beef Barbeque', 38000],
                    ['Main Course', 'Beef Black Pepper', 38000],
                    ['Main Course', 'Beef Teriyaki', 38000],
                    ['Main Course', 'Beef Yakiniku', 38000],
                    ['Main Course', 'Nasi Goreng MOQQA', 35000],
                    ['Main Course', 'Nasi Goreng Kampung', 40000],
                    ['Main Course', 'Soup Daging', 48000],

                    ['Indomie', 'Mie Rebus', 15000],
                    ['Indomie', 'Mie Nyemek MOQQA', 25000],

                    ['Spaghetti', 'Aglio Olio', 40000],
                    ['Spaghetti', 'Bolognese', 40000],
                    ['Spaghetti', 'Creamy Carbonara', 40000],
                ],


                // DESSERT (KATEGORI ID 5)

                5 => [
                    ['Dessert Series', 'Donat Gula', 25000],
                    ['Dessert Series', 'Pisang Goreng', 25000],
                    ['Dessert Series', 'Roti Bakar', 25000],
                    ['Dessert Series', 'Fudgy Brownies', 25000],
                    ['Dessert Series', 'Cheese Cake', 45000],
                ],

            ];


            /*
             * =====================================================
             * 3. MASUKKAN MENU MOQQA KE DATABASE
             *
             * Menu lama ID 1-24 tidak akan disentuh.
             * Menu MOQQA yang sudah ada tidak dimasukkan ulang.
             * =====================================================
             */

            foreach ($daftarMenu as $kategoriId => $items) {

                foreach ($items as $item) {

                    [$subkategori, $namaMenu, $harga] = $item;

                    // Periksa apakah menu sudah ada.
                    $sudahAda = DB::table('menu')
                        ->where('menu_id', '>', 24)
                        ->where('kategori_id', $kategoriId)
                        ->where('nama_menu', $namaMenu)
                        ->exists();

                    // Masukkan hanya jika belum ada.
                    if (!$sudahAda) {

                        DB::table('menu')->insert([
                            'kategori_id' => $kategoriId,
                            'nama_menu' => $namaMenu,
                            'deskripsi' => $subkategori,
                            'harga' => $harga,
                            'gambar' => null,
                            'stok' => 50,
                            'terjual' => 0,
                            'status' => 'tersedia',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

        });
    }
}