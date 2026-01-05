<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    // 1. DAFTAR PERMINTAAN BARANG (REQUISITION)
    public function index(Request $request)
    {
        $query = Requisition::query();

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
        $user = Auth::user();
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // --- C. STATISTIK ---
        $statsQuery = $query->clone();
        $totalRequests = $statsQuery->count();
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

        return view('pages.requisitions.index', compact('requests', 'totalRequests', 'countPending', 'consumables'));
    }

    // 2. FORM PERMINTAAN BARU
    public function create()
    {
        $assetCategories = \App\Models\Category::where('type', 'asset')->orderBy('name')->get();
        $consumableCategories = \App\Models\Category::where('type', 'consumable')->orderBy('name')->get();

        return view('pages.requisitions.create', compact('assetCategories', 'consumableCategories'));
    }

    // 3. SIMPAN PERMINTAAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:asset,consumable',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
        ]);

        Requisition::create($validated + [
            'user_id' => Auth::id(),
            'requestor_name' => Auth::user()->name,
            'status' => 'pending',
            'request_date' => now(),
        ]);

        return redirect()->route('permintaan.index')
            ->with('success', 'Permintaan barang berhasil dikirim.');
    }

    // 4. UPDATE STATUS / APPROVAL LOGIC (MENGURANGI STOK)
    public function updateStatus(Request $request, Requisition $requisition)
    {
        // Security Gate
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_note' => 'nullable|string',
            'consumable_id' => 'nullable|exists:consumables,id',
        ]);

        // LOGIKA APPROVAL + PENGURANGAN STOK (JIKA DIPILIH)
        if ($validated['status'] === 'approved' && !empty($validated['consumable_id'])) {

            $consumable = \App\Models\Consumable::with([
                'details' => function ($q) {
                    $q->where('current_stock', '>', 0)->orderBy('created_at', 'asc'); // FIFO
                }
            ])->find($validated['consumable_id']);

            // Validasi Kecukupan Stok
            $totalStock = $consumable->details->sum('current_stock');
            $requestedQty = $requisition->quantity;

            if ($totalStock < $requestedQty) {
                return back()->with('error', "Gagal! Stok {$consumable->name} hanya tersisa {$totalStock}, sedangkan permintaan {$requestedQty}.");
            }

            // PROSES PENGURANGAN STOK (TRANSACTION)
            DB::transaction(function () use ($consumable, $requestedQty, $requisition, $validated) {
                $sisaPermintaan = $requestedQty;

                foreach ($consumable->details as $batch) {
                    if ($sisaPermintaan <= 0)
                        break;

                    $ambil = min($batch->current_stock, $sisaPermintaan);

                    // 1. Kurangi Stok Batch
                    $batch->decrement('current_stock', $ambil);

                    // 2. Catat Transaksi Keluar
                    \App\Models\Transaction::create([
                        'user_id' => Auth::id(),
                        'consumable_detail_id' => $batch->id,
                        'type' => \App\Enums\TransactionType::KELUAR,
                        'amount' => $ambil,
                        'date' => now(),
                        'notes' => "Permintaan Barang: {$requisition->item_name} (ID: {$requisition->id}) | Kategori: " . ($requisition->category->name ?? '-'),
                    ]);

                    $sisaPermintaan -= $ambil;
                }

                // 3. Update Status Requisition
                $requisition->update([
                    'status' => 'approved',
                    'admin_note' => $validated['admin_note'] . " (Diambil dari stok: {$consumable->name})",
                    'response_date' => now(),
                ]);
            });

            return back()->with('success', 'Permintaan disetujui & stok berhasil dikurangi otomatis.');
        }

        // Logic Approval Biasa (Tanpa Potong Stok) atau Reject
        $requisition->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? null,
            'response_date' => now(),
        ]);

        return back()->with('success', 'Status permintaan diperbarui.');
    }

    // 5. HAPUS DATA
    public function destroy(Requisition $requisition)
    {
        $user = Auth::user();

        // Logic penghapusan
        if ($user->role === 'admin') {
            $requisition->delete();
            return back()->with('success', 'Permintaan dihapus oleh Admin.');
        }

        // User biasa
        if ($requisition->user_id === $user->id && $requisition->status === 'pending') {
            $requisition->delete();
            return back()->with('success', 'Permintaan Anda berhasil dibatalkan.');
        }

        return back()->withErrors(['Gagal! Anda tidak memiliki izin menghapus data ini.']);
    }
}
