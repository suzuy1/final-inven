<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Consumable;
use App\Enums\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Buat Query Dasar (Base Query)
        // Query ini diguankan untuk Statistik & Tabel
        // Eager load relasi penting untuk performa
        $query = Transaction::with(['detail.consumable', 'user']);

        // 2. Terapkan Filter Global (Search & Date)
        // Filter ini mempengaruhi KEDUANYA (Stats & Table)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('detail', function($q) use ($search) {
                $q->where('batch_code', 'like', "%$search%")
                  ->orWhereHas('consumable', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%$search%");
                  });
            });
        }

        if ($request->filled('start_date')) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // --- 3. HITUNG STATISTIK (SMART LOGIC) ---
        // Hitung stats DARI base query (sebelum filter type diaplikasikan)
        // Ini mencegah masalah "Zero-Out" saat user filter jenis transaksi.
        
        $summaryIn = $query->clone()->where('type', TransactionType::MASUK)->sum('amount');
        $summaryOut = $query->clone()->where('type', TransactionType::KELUAR)->sum('amount');

        // --- 4. FILTER SPESIFIK TABEL ---
        // Filter type hanya diaplikasikan ke data tabel, bukan ke kartu statistik
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // --- 5. PAGINATION ---
        $transactions = $query->latest('date')->latest('created_at')->paginate(10);

        // Kirim semua variabel ke View
        return view('pages.transactions.index', compact('transactions', 'summaryIn', 'summaryOut'));
    }

    public function create()
    {
        // Ambil Barang yang punya stok > 0
        // Kita kirim data 'consumables' (Induk), bukan batch spesifik
        $consumables = Consumable::whereHas('details', function($q) {
            $q->where('current_stock', '>', 0);
        })->with(['details' => function($q) {
            $q->where('current_stock', '>', 0);
        }])->get();

        return view('pages.transactions.create', compact('consumables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'consumable_id' => 'required|exists:consumables,id',
            'amount' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string', // Notes boleh kosong, jangan required
        ]);

        $item = Consumable::with(['details' => function($q) {
            $q->where('current_stock', '>', 0)->orderBy('created_at', 'asc'); // FIFO: Stok lama keluar dulu
        }])->findOrFail($request->consumable_id);

        // Validasi Stok Total
        $totalAvailable = $item->details->sum('current_stock');
        if ($totalAvailable < $request->amount) {
            return back()->withErrors(['amount' => "Stok tidak cukup! Total tersedia: $totalAvailable, Permintaan: {$request->amount}"]);
        }

        // LOGIKA FIFO
        DB::transaction(function () use ($request, $item) {
            $sisaPermintaan = $request->amount;

            foreach ($item->details as $batch) {
                if ($sisaPermintaan <= 0) break;

                // Ambil stok dari batch ini
                $ambil = min($batch->current_stock, $sisaPermintaan);

                // 1. Kurangi Stok Batch
                $batch->decrement('current_stock', $ambil);

                // 2. Catat Transaksi
                Transaction::create([
                    'user_id' => Auth::id(),
                    'consumable_detail_id' => $batch->id,
                    'type' => TransactionType::KELUAR,
                    'amount' => $ambil,
                    'date' => $request->date,
                    'notes' => $request->notes . " (Batch: {$batch->batch_code})", // Catat batch mana yang diambil
                ]);

                $sisaPermintaan -= $ambil;
            }
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dicatat (Metode FIFO).');
    }
}