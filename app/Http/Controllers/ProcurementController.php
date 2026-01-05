<?php

namespace App\Http\Controllers;

use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk perhitungan cepat

class ProcurementController extends Controller
{
    // 1. DAFTAR USULAN (OPTIMIZED FOR DASHBOARD STATS)
    public function index(Request $request)
    {
        $query = Procurement::query();

        // --- A. FILTERING ---
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                    ->orWhere('requestor_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // --- B. SECURITY SCOPE ---
        // Simpan role user ke variabel biar gak manggil Auth berulang kali
        $user = Auth::user();
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // --- C. STATISTIK (STRATEGIC CALCULATION) ---
        // Kita clone query dasar sebelum dipaginate untuk menghitung total statistik
        // Ini PENTING agar angka di kartu atas tetap akurat meski ada di halaman 2, 3, dst.

        $statsQuery = $query->clone(); // Duplikat query beserta filter yang sedang aktif

        // 1. Hitung Total Anggaran (Harga * Qty) langsung di Database (Lebih Cepat daripada PHP)
        $totalBudget = $statsQuery->sum(DB::raw('unit_price_estimation * quantity'));

        // 2. Hitung Jumlah Pending (Opsional, untuk kartu 'Menunggu Persetujuan')
        // Jika user memfilter status 'approved', maka pending pasti 0. Logic ini menyesuaikan filter.
        $countPending = $statsQuery->clone()->where('status', 'pending')->count();

        // --- D. DATA UNTUK MODAL APPROVAL (ADMIN ONLY) ---
        $consumables = [];
        if ($user->role === 'admin') {
            // Ambil barang yang punya stok
            $consumables = \App\Models\Consumable::whereHas('details', function ($q) {
                $q->where('current_stock', '>', 0);
            })->withSum('details', 'current_stock')->get();
        }

        // --- E. PAGINATION (dengan eager loading category) ---
        $requests = $query->with('category')->latest()->paginate(10);

        return view('pages.procurements.index', compact('requests', 'totalBudget', 'countPending', 'consumables'));
    }

    // 2. FORM USULAN BARU
    public function create()
    {
        // Ambil semua kategori untuk dropdown
        // Kita bisa kirim semua dan filter di frontend, atau pisah variable
        $assetCategories = \App\Models\Category::where('type', 'asset')->orderBy('name')->get();
        $consumableCategories = \App\Models\Category::where('type', 'consumable')->orderBy('name')->get();

        return view('pages.procurements.create', compact('assetCategories', 'consumableCategories'));
    }

    // 3. SIMPAN USULAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:asset,consumable',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id', // Wajib pilih kategori
            'description' => 'nullable|string', // Ubah ke nullable jika tidak wajib
            'unit_price_estimation' => 'nullable|numeric|min:0',
        ]);

        // Gunakan $validated array untuk clean code, override field tertentu
        Procurement::create($validated + [
            'user_id' => Auth::id(),
            'requestor_name' => Auth::user()->name,
            'status' => 'pending',
            'request_date' => now(),
        ]);

        return redirect()->route('pengadaan.index')
            ->with('success', 'Usulan pengadaan berhasil dikirim.');
    }

    // 4. UPDATE STATUS / APPROVAL LOGIC (PENGADAAN)
    public function updateStatus(Request $request, Procurement $procurement)
    {
        // Security Gate
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_note' => 'nullable|string',
            'consumable_id' => 'nullable|exists:consumables,id', // Untuk completed: input ke inventaris mana
        ]);

        // ========================================================================
        // APPROVAL: Setujui pengadaan (TIDAK mengurangi stok)
        // ========================================================================
        if ($validated['status'] === 'approved') {
            $procurement->update([
                'status' => 'approved',
                'admin_note' => $validated['admin_note'] ?? 'Disetujui untuk proses pembelian',
                'response_date' => now(),
            ]);

            return back()->with('success', 'Usulan pengadaan disetujui. Silakan lanjutkan proses pembelian.');
        }

        // ========================================================================
        // REJECTION: Tolak pengadaan
        // ========================================================================
        if ($validated['status'] === 'rejected') {
            $procurement->update([
                'status' => 'rejected',
                'admin_note' => $validated['admin_note'] ?? 'Ditolak',
                'response_date' => now(),
            ]);

            return back()->with('success', 'Usulan pengadaan ditolak.');
        }

        // ========================================================================
        // COMPLETED: Barang datang dari vendor → TAMBAH STOK
        // ========================================================================
        if ($validated['status'] === 'completed' && !empty($validated['consumable_id'])) {
            // Validasi Tambahan untuk Data Stok Masuk
            $dataMasuk = $request->validate([
                'batch_code' => 'required|string|max:50',
                'unit_price' => 'required|numeric|min:0',
            ]);

            $consumable = \App\Models\Consumable::findOrFail($validated['consumable_id']);
            $qty = $procurement->quantity;
            $batchCode = $dataMasuk['batch_code'];
            $price = $dataMasuk['unit_price'];

            DB::transaction(function () use ($consumable, $qty, $batchCode, $price, $procurement, $validated) {
                // 1. Buat Batch Baru (Detail Consumable)
                $detail = \App\Models\ConsumableDetail::create([
                    'consumable_id' => $consumable->id,
                    'batch_code' => $batchCode,
                    'initial_stock' => $qty,
                    'current_stock' => $qty,
                    'unit_price' => $price,
                ]);

                // 2. Catat Transaksi Masuk
                \App\Models\Transaction::create([
                    'user_id' => Auth::id(),
                    'consumable_detail_id' => $detail->id,
                    'type' => \App\Enums\TransactionType::MASUK,
                    'amount' => $qty,
                    'date' => now(),
                    'notes' => "Pengadaan Selesai: {$procurement->item_name} (ID: {$procurement->id}) | Kategori: " . ($procurement->category->name ?? '-'),
                ]);

                // 3. Update Status Procurement
                $procurement->update([
                    'status' => 'completed',
                    'admin_note' => $validated['admin_note'] . " (Masuk ke stok: {$consumable->name}, Batch: {$batchCode})",
                    'response_date' => now(),
                ]);
            });

            return back()->with('success', 'Pengadaan selesai & stok berhasil ditambahkan ke inventaris.');
        }

        // ========================================================================
        // COMPLETED TANPA INPUT STOK: Hanya tandai selesai
        // ========================================================================
        if ($validated['status'] === 'completed') {
            $procurement->update([
                'status' => 'completed',
                'admin_note' => $validated['admin_note'] ?? 'Selesai tanpa input stok',
                'response_date' => now(),
            ]);

            return back()->with('success', 'Pengadaan ditandai selesai.');
        }

        // Fallback (seharusnya tidak pernah sampai sini)
        return back()->with('error', 'Status tidak valid.');
    }

    // 5. HAPUS DATA
    public function destroy(Procurement $procurement)
    {
        $user = Auth::user();

        // Logic penghapusan
        if ($user->role === 'admin') {
            // Admin bebas hapus
            $procurement->delete();
            return back()->with('success', 'Usulan dihapus oleh Admin.');
        }

        // User biasa
        if ($procurement->user_id === $user->id && $procurement->status === 'pending') {
            $procurement->delete();
            return back()->with('success', 'Usulan Anda berhasil dibatalkan.');
        }

        return back()->withErrors(['Gagal! Anda tidak memiliki izin menghapus data ini.']);
    }
}