<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Enums\AssetCondition; // Pastikan namespace Enum ini benar

class InventoryController extends Controller
{
    // 1. HALAMAN KATEGORI (Dashboard Aset)
    public function indexCategories()
    {
        // Saya tambahkan withCount agar Kartu Kategori di View menampilkan angka statistik
        // Asumsi: Relasi 'inventories' ada di model Category
        $categories = Category::where('type', 'asset')
            ->withCount(['inventories as total_types', 'assets as total_units'])
            ->get();

        return view('pages.inventories.categories', compact('categories'));
    }

    // 2. DAFTAR BARANG (Dengan Filter & Pagination)
    public function indexItems(Request $request, Category $category)
    {
        $search = $request->input('search');

        // Query Utama
        $query = Inventory::where('category_id', $category->id)
            ->withCount([
                'details as total_unit',
                // Hitung kondisi aset secara real-time dari database
                'details as baik' => function ($q) {
                    $q->where('condition', AssetCondition::BAIK->value);
                },
                'details as rusak_ringan' => function ($q) {
                    $q->where('condition', AssetCondition::RUSAK_RINGAN->value);
                },
                'details as rusak_berat' => function ($q) {
                    $q->where('condition', AssetCondition::RUSAK_BERAT->value);
                }
            ]);

        // LOGIKA SEARCH (Ini yang kamu lupakan!)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Pagination wajib ada
        $items = $query->latest()->paginate(10);

        return view('pages.inventories.items', compact('category', 'items'));
    }

    // 3. FORM TAMBAH BARANG
    public function create(Category $category)
    {
        return view('pages.inventories.create', compact('category'));
    }

    // 4. SIMPAN BARANG
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $inventory = Inventory::create($request->all());

        // UX Bagus dari kamu: Langsung redirect ke input unit fisik
        return redirect()->route('asset.index', $inventory->id)
            ->with('success', 'Data induk berhasil dibuat. Silakan tambahkan unit fisik.');
    }

    // 5. EDIT FORM
    public function edit(Inventory $inventaris)
    {
        // Pakai Route Model Binding yang konsisten
        $categories = Category::where('type', 'asset')->get();
        return view('pages.inventories.edit', compact('inventaris', 'categories'));
    }

    // 6. UPDATE DATA
    public function update(Request $request, Inventory $inventaris)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        $inventaris->update($request->all());

        return redirect()->route('inventaris.items', $inventaris->category_id)
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    // 7. DESTROY (CASCADE DELETE - BERBAHAYA!)
    public function destroy(Inventory $inventaris)
    {
        // Hitung jumlah detail units
        $totalUnits = $inventaris->details()->count();

        // Jika ada detail units, lakukan validasi ketat
        if ($totalUnits > 0) {
            // VALIDASI 1: Cek apakah ada unit yang sedang dipinjam
            $borrowedUnits = $inventaris->details()
                ->where('status', \App\Enums\AssetStatus::DIPINJAM->value)
                ->count();

            if ($borrowedUnits > 0) {
                return back()->withErrors([
                    'error' => "Tidak dapat menghapus! Ada {$borrowedUnits} unit yang sedang dipinjam. Kembalikan semua unit terlebih dahulu."
                ]);
            }

            // VALIDASI 2: Cek apakah ada unit dengan mutasi pending
            $pendingMutations = \App\Models\Mutation::whereIn(
                'asset_id',
                $inventaris->details()->pluck('id')
            )->where('status', \App\Enums\MutationStatus::PENDING->value)->count();

            if ($pendingMutations > 0) {
                return back()->withErrors([
                    'error' => "Tidak dapat menghapus! Ada {$pendingMutations} mutasi pending. Selesaikan proses mutasi terlebih dahulu."
                ]);
            }

            // CASCADE DELETE dengan Database Transaction
            try {
                \DB::beginTransaction();

                $itemName = $inventaris->name;
                $categoryId = $inventaris->category_id;

                // Hapus semua detail units terlebih dahulu
                $inventaris->details()->delete();

                // Hapus inventory induk
                $inventaris->delete();

                \DB::commit();

                return redirect()->route('inventaris.items', $categoryId)
                    ->with('success', "Data induk '{$itemName}' dan {$totalUnits} unit fisik berhasil dihapus dari sistem.");

            } catch (\Exception $e) {
                \DB::rollBack();
                return back()->withErrors([
                    'error' => 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
                ]);
            }
        }

        // Jika tidak ada detail units, hapus langsung
        $categoryId = $inventaris->category_id;
        $itemName = $inventaris->name;
        $inventaris->delete();

        return redirect()->route('inventaris.items', $categoryId)
            ->with('success', "Data induk '{$itemName}' berhasil dihapus.");
    }
}