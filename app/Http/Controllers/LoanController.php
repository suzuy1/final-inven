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
            if ($request->status == \App\Enums\LoanStatus::OVERDUE->value) {
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
            ->paginate(10);

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

        $asset = AssetDetail::findOrFail($request->asset_detail_id);

        // Validasi Terakhir: Pastikan barang masih tersedia (mencegah race condition)
        if ($asset->status != \App\Enums\AssetStatus::TERSEDIA) {
            return back()->withErrors(['asset_detail_id' => 'Gagal! Barang ini baru saja dipinjam orang lain.']);
        }

        // Validasi Kondisi: Barang rusak berat tidak boleh dipinjam
        if ($asset->condition == 'rusak_berat') {
            return back()->withErrors(['asset_detail_id' => 'Gagal! Barang ini dalam kondisi rusak berat dan tidak dapat dipinjam.']);
        }

        DB::transaction(function () use ($request, $asset) {
            // A. Simpan Data Peminjaman
            Loan::create([
                'asset_detail_id' => $asset->id,
                'borrower_name' => $request->borrower_name,
                'borrower_id' => $request->borrower_id,
                'loan_date' => $request->loan_date,
                'return_date_plan' => $request->return_date_plan,
                'status' => \App\Enums\LoanStatus::DIPINJAM, // Set status awal
                'notes' => $request->notes
            ]);

            // B. Update Status Aset menjadi 'dipinjam'
            $asset->update(['status' => \App\Enums\AssetStatus::DIPINJAM]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    // 4. PROSES PENGEMBALIAN BARANG
    public function returnItem(Request $request, Loan $loan)
    {
        $request->validate([
            'condition_after' => 'required|in:baik,rusak_ringan,rusak_berat',
            'return_notes' => 'nullable|string'
        ]);

        if ($loan->status == \App\Enums\LoanStatus::KEMBALI) {
            return back()->withErrors(['Barang ini sudah dikembalikan sebelumnya.']);
        }

        DB::transaction(function () use ($request, $loan) {
            // A. Update Data Peminjaman (Selesai)
            $loan->update([
                'status' => \App\Enums\LoanStatus::KEMBALI,
                'return_date_actual' => now(),
                'notes' => $loan->notes . " [Kondisi Balik: " . ucfirst(str_replace('_', ' ', $request->condition_after)) . ". Catatan: " . $request->return_notes . "]"
            ]);

            // B. Update Status Aset (Tersedia Kembali + Update Kondisi Fisik)
            $loan->asset->update([
                'status' => \App\Enums\AssetStatus::TERSEDIA,
                'condition' => $request->condition_after
            ]);
        });

        return back()->with('success', 'Barang berhasil dikembalikan dan status aset diperbarui.');
    }
}