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
            $query->where(function($q) use ($search) {
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
        
        // --- D. PAGINATION ---
        $requests = $query->latest()->paginate(10);

        return view('pages.procurements.index', compact('requests', 'totalBudget', 'countPending'));
    }

    // 2. FORM USULAN BARU
    public function create()
    {
        return view('pages.procurements.create');
    }

    // 3. SIMPAN USULAN
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'type' => 'required|in:asset,consumable',
            'quantity' => 'required|integer|min:1',
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

    // 4. UPDATE STATUS
    public function updateStatus(Request $request, Procurement $procurement)
    {
        // Security Gate
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected,completed',
            'admin_note' => 'nullable|string',
        ]);

        $procurement->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'],
            'response_date' => now(), // Catat kapan admin merespon
        ]);

        return back()->with('success', 'Status usulan diperbarui.');
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