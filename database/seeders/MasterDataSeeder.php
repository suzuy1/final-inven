<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Room;
use App\Models\Category;
use App\Models\FundingSource;
use App\Models\Inventory;
use App\Models\AssetDetail;
use App\Models\Consumable;
use App\Models\ConsumableDetail;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. BUAT SUMBER DANA (FUNDING)
        // ==========================================
        $yys = FundingSource::create(['code' => 'YYS', 'name' => 'Dana Yayasan']);
        $bos = FundingSource::create(['code' => 'BOS', 'name' => 'Bantuan Operasional']);
        $hibah = FundingSource::create(['code' => 'HIBAH', 'name' => 'Hibah Dikti']);

        // ==========================================
        // 2. BUAT UNIT & RUANGAN (LOCATION)
        // ==========================================

        // Unit 1: FIK
        $fik = Unit::create(['name' => 'Fakultas Ilmu Komputer', 'code' => 'FIK', 'status' => 'aktif']);
        // Simpan ruangan ke variabel agar bisa dipakai nanti
        $labRPL = Room::create(['unit_id' => $fik->id, 'name' => 'Lab. Rekayasa Perangkat Lunak', 'location' => 'Gedung B, Lt 2', 'status' => 'tersedia']);
        $labJarkom = Room::create(['unit_id' => $fik->id, 'name' => 'Lab. Jaringan', 'location' => 'Gedung B, Lt 3', 'status' => 'tersedia']);
        $ruangDosen = Room::create(['unit_id' => $fik->id, 'name' => 'Ruang Dosen FIK', 'location' => 'Gedung A, Lt 1', 'status' => 'digunakan']);

        // Unit 2: BAAK
        $baak = Unit::create(['name' => 'Biro Administrasi (BAAK)', 'code' => 'BAAK', 'status' => 'aktif']);
        $loket = Room::create(['unit_id' => $baak->id, 'name' => 'Loket Pelayanan', 'location' => 'Gedung Pusat, Lt 1', 'status' => 'tersedia']);

        // Unit 3: Sarpras
        $sarpras = Unit::create(['name' => 'Bagian Umum & Sarpras', 'code' => 'SARPRAS', 'status' => 'aktif']);
        $gudang = Room::create(['unit_id' => $sarpras->id, 'name' => 'Gudang Inventaris Utama', 'location' => 'Gedung Belakang', 'status' => 'tersedia']);

        // ==========================================
        // 3. PASTIKAN KATEGORI ADA
        // ==========================================
        // Kita pakai firstOrCreate biar gak error kalau sudah ada dari CategorySeeder
        $catElektronik = Category::firstOrCreate(['name' => 'Elektronik'], ['type' => 'asset']);
        $catFurniture = Category::firstOrCreate(['name' => 'Furniture'], ['type' => 'asset']);
        $catATK = Category::firstOrCreate(['name' => 'BHP ATK'], ['type' => 'consumable']);
        $catMedis = Category::firstOrCreate(['name' => 'BHP Medis'], ['type' => 'consumable']);

        // ==========================================
        // 4. BUAT ASET TETAP (INVENTARIS)
        // ==========================================

        // A. Induk: Laptop
        $laptop = Inventory::create([
            'name' => 'Laptop ASUS ROG Zephyrus',
            'category_id' => $catElektronik->id,
            'description' => 'Laptop spesifikasi tinggi untuk praktikum multimedia dan game dev.'
        ]);

        // Detail Unit Laptop (Anak)
        AssetDetail::create([
            'inventory_id' => $laptop->id,
            'unit_code' => 'INV/YYS/LAP/001',
            'model_name' => 'ROG Zephyrus G14 (Ryzen 9)',
            'status' => 'tersedia',
            'condition' => 'baik',
            'room_id' => $labRPL->id, // Masuk Lab RPL
            'funding_source_id' => $yys->id,
            'price' => 25000000,
            'purchase_date' => '2024-01-15'
        ]);

        AssetDetail::create([
            'inventory_id' => $laptop->id,
            'unit_code' => 'INV/YYS/LAP/002',
            'model_name' => 'ROG Zephyrus G14 (Ryzen 7)',
            'status' => 'dipinjam', // Ceritanya sedang dipinjam
            'condition' => 'baik',
            'room_id' => $labRPL->id,
            'funding_source_id' => $yys->id,
            'price' => 23000000,
            'purchase_date' => '2024-01-15'
        ]);

        // B. Induk: Proyektor
        $proyektor = Inventory::create([
            'name' => 'Proyektor Epson',
            'category_id' => $catElektronik->id,
            'description' => 'Proyektor gantung untuk ruang kelas.'
        ]);

        AssetDetail::create([
            'inventory_id' => $proyektor->id,
            'unit_code' => 'INV/BOS/PRJ/001',
            'model_name' => 'Epson EB-X500',
            'status' => 'tersedia',
            'condition' => 'rusak_ringan', // Contoh barang rusak
            'room_id' => $ruangDosen->id,
            'funding_source_id' => $bos->id,
            'price' => 5500000,
            'purchase_date' => '2023-06-20'
        ]);

        // ==========================================
        // 5. BUAT BARANG HABIS PAKAI (BHP)
        // ==========================================

        // A. Induk: Spidol
        $spidol = Consumable::create([
            'name' => 'Spidol Boardmarker Hitam',
            'unit' => 'Pcs',
            'category_id' => $catATK->id,
            'notes' => 'Stok wajib di setiap kelas'
        ]);

        // Batch Spidol (Stok)
        ConsumableDetail::create([
            'consumable_id' => $spidol->id,
            'batch_code' => 'BHP/BOS/ATK/001',
            'model_name' => 'Snowman Boardmarker',
            'initial_stock' => 50,
            'current_stock' => 45, // Sudah terpakai 5
            'room_id' => $gudang->id,
            'funding_source_id' => $bos->id,
            'purchase_date' => '2024-11-01',
            'expiry_date' => null // ATK gak ada expired
        ]);

        // B. Induk: Obat Paracetamol
        $obat = Consumable::create([
            'name' => 'Paracetamol 500mg',
            'unit' => 'Strip',
            'category_id' => $catMedis->id,
            'notes' => 'P3K Utama'
        ]);

        // Batch Obat (Expired Dekat)
        ConsumableDetail::create([
            'consumable_id' => $obat->id,
            'batch_code' => 'BHP/HIBAH/MED/001',
            'model_name' => 'Sanbe Farma',
            'initial_stock' => 100,
            'current_stock' => 20,
            'room_id' => $loket->id, // Disimpan di loket buat jaga2
            'funding_source_id' => $hibah->id,
            'purchase_date' => '2023-01-01',
            'expiry_date' => '2024-12-31' // Mau expired (Bagus buat demo dashboard alert)
        ]);

        // Batch Obat (Baru)
        ConsumableDetail::create([
            'consumable_id' => $obat->id,
            'batch_code' => 'BHP/YYS/MED/002',
            'model_name' => 'Kimia Farma',
            'initial_stock' => 50,
            'current_stock' => 50,
            'room_id' => $gudang->id,
            'funding_source_id' => $yys->id,
            'purchase_date' => '2024-10-01',
            'expiry_date' => '2026-10-01'
        ]);
    }
}