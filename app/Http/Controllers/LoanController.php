<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\AssetDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    // 1. DAFTAR PEMINJAMAN (Index)
    public function index(Request $request)
    {
        $query = Loan::with('asset.inventory');

        // --- FILTER SEARCH (Jangan Dihapus!) ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('borrower_name', 'like', "%$search%")
                    ->orWhere('borrower_id', 'like', "%$search%") // NIM atau NIP
                    ->orWhereHas('asset', function ($subQ) use ($search) {
                        $subQ->where('unit_code', 'like', "%$search%")
                            ->orWhereHas('inventory', function ($invQ) use ($search) {
                                $invQ->where('name', 'like', "%$search%");
                            });
                    });
            });
        }

        // --- FILTER STATUS ---
        if ($request->filled('status')) {
            // 'overdue' adalah filter value (bukan enum case), untuk cari yang dipinjam + telat
            if ($request->status == 'overdue') {
                $query->where('status', \App\Enums\LoanStatus::DIPINJAM)->where('return_date_plan', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        // --- SORTING (Prioritas: Dipinjam > Telat > Kembali) ---
        // Ini adaptasi dari logika CASE WHEN kamu, tapi digabung dengan filter di atas
        $loans = $query->orderByRaw("CASE 
                        WHEN status = '" . \App\Enums\LoanStatus::DIPINJAM->value . "' THEN 1 
                        WHEN status = '" . \App\Enums\LoanStatus::KEMBALI->value . "' THEN 3 
                        ELSE 2 END")
            ->latest('loan_date')
            ->paginate(10)
            ->appends(request()->query()); // ✅ Preserve filter saat pagination

        return view('pages.loans.index', compact('loans'));
    }

    // 2. FORM PINJAM BARANG
    public function create()
    {
        // Ambil hanya aset yang statusnya 'tersedia' dan kondisinya tidak 'rusak_berat'
        // Kita ambil list AssetDetail (Unit Fisik) langsung agar user memilih unit spesifik (misal: Laptop SN 123)
        $assets = AssetDetail::with(['inventory', 'room'])
            ->where('status', \App\Enums\AssetStatus::TERSEDIA)
            ->where('condition', '!=', 'rusak_berat')
            ->get();

        return view('pages.loans.create', compact('assets'));
    }

    public function show(Loan $loan)
    {
        $loan->load(['asset.inventory', 'asset.room']);
        return view('pages.loans.show', compact('loan'));
    }

    // 3. PROSES SIMPAN PEMINJAMAN
    public function store(Request $request)
    {
        $request->validate([
            'asset_detail_id' => 'required|exists:asset_details,id',
            'borrower_name' => 'required|string',
            'borrower_id' => 'required|string',
            'loan_date' => 'required|date',
            'return_date_plan' => 'required|date|after_or_equal:loan_date',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // ✅ FIX: Pessimistic locking untuk prevent race condition (double booking)
                $asset = AssetDetail::lockForUpdate()
                    ->findOrFail($request->asset_detail_id);

                // Validasi DALAM transaction (setelah lock)
                if ($asset->status != \App\Enums\AssetStatus::TERSEDIA) {
                    throw new \Exception('Gagal! Barang ini baru saja dipinjam orang lain.');
                }

                // Validasi Kondisi: Barang rusak berat tidak boleh dipinjam
                if ($asset->condition == 'rusak_berat') {
                    throw new \Exception('Gagal! Barang ini dalam kondisi rusak berat dan tidak dapat dipinjam.');
                }

                // A. Simpan Data Peminjaman
                Loan::create([
                    'asset_detail_id' => $asset->id,
                    'borrower_name' => $request->borrower_name,
                    'borrower_id' => $request->borrower_id,
                    'loan_date' => $request->loan_date,
                    'return_date_plan' => $request->return_date_plan,
                    'status' => \App\Enums\LoanStatus::DIPINJAM,
                    'notes' => $request->notes
                ]);

                // B. Update Status Aset menjadi 'dipinjam'
                $asset->update(['status' => \App\Enums\AssetStatus::DIPINJAM]);
            });

            return redirect()->route('peminjaman.index')
                ->with('success', 'Peminjaman berhasil dicatat.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    // 4. PROSES PENGEMBALIAN BARANG
    public function returnItem(Request $request, Loan $loan)
    {
        $request->validate([
            'condition_after' => 'required|in:baik,rusak_ringan,rusak_berat',
            'return_notes' => 'nullable|string'
        ]);

        if ($loan->status == \App\Enums\LoanStatus::KEMBALI) {
            return back()->with('error', 'Barang ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($request, $loan) {
            // A. Update Data Peminjaman (Selesai) - Simpan ke kolom terpisah
            $loan->update([
                'status' => \App\Enums\LoanStatus::KEMBALI,
                'return_date_actual' => now(),
                'condition_after' => $request->condition_after,
                'return_notes' => $request->return_notes
            ]);

            // ✅ FIX: Jangan set TERSEDIA jika rusak berat!
            // Aset rusak berat harus masuk status RUSAK, bukan TERSEDIA
            $newStatus = ($request->condition_after == 'rusak_berat')
                ? \App\Enums\AssetStatus::RUSAK
                : \App\Enums\AssetStatus::TERSEDIA;

            // B. Update Status Aset + Kondisi Fisik
            $loan->asset->update([
                'status' => $newStatus,
                'condition' => $request->condition_after
            ]);
        });

        $message = ($request->condition_after == 'rusak_berat')
            ? 'Barang dikembalikan dengan kondisi rusak berat. Status aset diubah menjadi RUSAK.'
            : 'Barang berhasil dikembalikan dan status aset diperbarui.';

        return back()->with('success', $message);
    }
}