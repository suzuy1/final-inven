<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Consumable;
use App\Models\ConsumableDetail;
use App\Models\Room;
use App\Models\FundingSource;
use App\Models\Transaction; // <-- Tambahin ini kalo belum ada, buat model Transaction
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- Ini juga, buat Auth::id()

class ConsumableController extends Controller
{
    // HALAMAN 1: PILIH KATEGORI (Khusus Type Consumable)
    public function indexCategories()
    {
        $categories = Category::where('type', 'consumable')->get();
        return view('pages.consumables.categories', compact('categories'));
    }

    // HALAMAN 2: DAFTAR BARANG (Induk)
    public function indexItems(Category $category)
    {
        // Ambil barang beserta total stok & tgl kadaluarsa tercepat
        $items = Consumable::where('category_id', $category->id)
            ->with(['details']) // Load relasi
            ->get()
            ->map(function ($item) {
                // Hitung Total Stok dari semua batch
                $item->total_stock = $item->details->sum('current_stock');

                // Cari kadaluarsa paling dekat
                $item->nearest_expiry = $item->details->min('expiry_date');

                // Update Stok Terakhir = created_at dari batch terbaru
                $latestBatch = $item->details->sortByDesc('created_at')->first();
                $item->last_stock_update = $latestBatch ? $latestBatch->created_at : null;

                return $item;
            });

        return view('pages.consumables.items', compact('category', 'items'));
    }

    // HALAMAN 3: Form Tambah BHP
    public function create(Category $category)
    {
        return view('pages.consumables.create', compact('category'));
    }

    // SIMPAN INDUK
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'check_date' => 'nullable|date',
        ]);
        $consumable = Consumable::create($request->all());

        // Redirect langsung ke detail (sama seperti inventaris)
        return redirect()->route('consumable.detail', $consumable->id);
    }

    // HALAMAN FORM TAMBAH BATCH (STOK BARU)
    public function createBatch(Consumable $consumable)
    {
        // Ambil data master untuk dropdown
        $rooms = Room::with('unit')->get();
        $fundings = FundingSource::all();

        return view('pages.consumables.create_batch', compact('consumable', 'rooms', 'fundings'));
    }

    // HALAMAN 3: DETAIL BATCH (Anak)
    public function detail(Consumable $consumable)
    {
        // Ambil detail batch urut dari yang terlama (001, 002...)
        $details = $consumable->details()->with(['room', 'fundingSource'])->oldest()->get();

        // Ambil Data Master Ruangan
        $rooms = Room::with('unit')->get();

        // Ambil Data Master Sumber Dana (INI YANG PENTING AGAR DROPDOWN MUNCUL)
        $fundings = FundingSource::all();

        return view('pages.consumables.details', compact('consumable', 'details', 'rooms', 'fundings'));
    }

    // SIMPAN DETAIL BATCH (Dengan Transaction & Locking)
    public function storeDetail(Request $request)
    {
        $request->validate([
            'consumable_id' => 'required',
            'model_name' => 'required',
            'initial_stock' => 'required|integer|min:1',
            'funding_source_id' => 'required',
            'purchase_date' => 'required|date',
            // ... validasi lain
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
                // 1. Lock Parent (Consumable) agar tidak ada concurrent insert ke parent yang sama
                // Ini mencegah Race Condition saat penghitungan counter
                $consumable = Consumable::lockForUpdate()->findOrFail($request->consumable_id);
                $sumber = FundingSource::findOrFail($request->funding_source_id);

                // 2. LOGIKA GENERATE KODE (Sekarang Aman)
                $counter = ConsumableDetail::where('consumable_id', $consumable->id)->count() + 1;

                // Keep trying until we find a free slot (safety net, walau sudah dilock)
                do {
                    $sequence = str_pad($counter, 3, '0', STR_PAD_LEFT);
                    $code = "BHP/" . $sumber->code . "/" . $consumable->category_id . "/" . $sequence;
                    $exists = ConsumableDetail::where('batch_code', $code)->exists();
                    if ($exists)
                        $counter++;
                } while ($exists);

                // 3. Simpan Detail
                $batch = ConsumableDetail::create(array_merge($request->all(), [
                    'batch_code' => $code,
                    'current_stock' => $request->initial_stock
                ]));

                // 4. Catat Transaksi Masuk
                \App\Models\Transaction::create([
                    'user_id' => \Illuminate\Support\Facades\Auth::id(),
                    'consumable_detail_id' => $batch->id,
                    'type' => \App\Enums\TransactionType::MASUK,
                    'amount' => $request->initial_stock,
                    'date' => now(),
                    'notes' => 'Stok Awal / Pembelian Baru (Batch: ' . $code . ')',
                ]);

                return back()->with('success', 'Batch berhasil ditambahkan. Kode: ' . $code);
            });
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }



    // HALAMAN EDIT BATCH
    public function editBatch(ConsumableDetail $consumableDetail)
    {
        $detail = $consumableDetail; // Alias biar enak
        $rooms = Room::with('unit')->get();
        $fundings = FundingSource::all();

        return view('pages.consumables.edit_batch', compact('detail', 'rooms', 'fundings'));
    }

    // UPDATE BATCH
    public function updateBatch(Request $request, ConsumableDetail $consumableDetail)
    {
        $request->validate([
            'model_name' => 'required',
            'purchase_date' => 'required|date',
            'room_id' => 'required',
            'funding_source_id' => 'required',
            'current_stock' => 'required|integer|min:0',
        ]);

        // Cek jika ada perubahan stok manual (Stock Opname)
        if ($request->current_stock != $consumableDetail->current_stock) {
            // Catat history perubahan stok (Adjustment)
            $diff = $request->current_stock - $consumableDetail->current_stock;
            \App\Models\Transaction::create([
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'consumable_detail_id' => $consumableDetail->id,
                'type' => $diff > 0 ? \App\Enums\TransactionType::MASUK : \App\Enums\TransactionType::KELUAR,
                'amount' => abs($diff),
                'date' => now(),
                'notes' => 'Koreksi Stok / Stock Opname (Manual Update)',
            ]);
        }

        $consumableDetail->update($request->all());

        return redirect()->route('consumable.detail', $consumableDetail->consumable_id)
            ->with('success', 'Data batch stok berhasil diperbarui.');
    }

    // DELETE BATCH
    public function destroyBatch(ConsumableDetail $consumableDetail)
    {
        // Cek apakah sudah ada transaksi keluar selain inisiasi?
        $hasUsage = $consumableDetail->transactions()
            ->where('type', '!=', \App\Enums\TransactionType::MASUK)
            ->exists();

        if ($hasUsage) {
            return back()->with('error', 'Batch ini sudah memiliki riwayat pemakaian (mutasi keluar). Tidak bisa dihapus.');
        }

        $parentId = $consumableDetail->consumable_id;

        // Hapus transaksi terkait (Purchase awal)
        $consumableDetail->transactions()->delete();

        // Hapus batch
        $consumableDetail->delete();

        return redirect()->route('consumable.detail', $parentId)
            ->with('success', 'Data batch stok berhasil dihapus.');
    }


    // EDIT PARENT ITEM
    public function edit(Consumable $consumable)
    {
        return view('pages.consumables.edit', compact('consumable'));
    }

    // UPDATE PARENT ITEM
    public function update(Request $request, Consumable $consumable)
    {
        $request->validate([
            'name' => 'required',
            'unit' => 'required',
            'check_date' => 'nullable|date',
        ]);

        $consumable->update($request->all());

        return redirect()->route('bhp.items', $consumable->category_id)
            ->with('success', 'Data barang berhasil diperbarui.');
    }

    // DELETE PARENT ITEM
    public function destroy(Consumable $consumable)
    {
        // Cek apakah ada detail/history?
        if ($consumable->details()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus barang yang sudah memiliki riwayat stok/detail. Hapus semua detail terlebih dahulu.');
        }

        $categoryId = $consumable->category_id; // Simpan dulu buat redirect
        $consumable->delete();

        return redirect()->route('bhp.items', $categoryId)
            ->with('success', 'Data barang berhasil dihapus.');
    }
}