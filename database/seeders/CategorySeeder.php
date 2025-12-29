<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kategori untuk Aset Tetap (Barang Tidak Habis Pakai)
        $assets = [
            'Elektronik',
            'Furniture',
            'Kendaraan',
            // Catatan: ATK dan Kebersihan di sini diasumsikan ASET UTAMA,
            // seperti mesin fotokopi, vacuum cleaner industri, dsb.
            'Alat Tulis Kantor', 
            'Peralatan Listrik',
            'Peralatan Kebersihan',
            'Peralatan Dapur',
            'Peralatan Medis',
            'Peralatan Teknologi'
        ];
        
        // Loop untuk membuat kategori Aset
        foreach ($assets as $cat) {
            Category::create(['name' => $cat, 'type' => 'asset']);
        }

        // 2. Kategori untuk Barang Habis Pakai (BHP)
        $consumables = [
            'BHP Medis',
            'BHP Kebersihan',
            'BHP ATK',
            'Obat'
        ];

        // Loop untuk membuat kategori Consumable
        foreach ($consumables as $c) {
            Category::create(['name' => $c, 'type' => 'consumable']);
        }
    }
}