<?php

namespace App\Http\Controllers;

use App\Enums\ProcurementStatus;
use App\Http\Requests\StoreProcurementRequest;
use App\Http\Requests\UpdateProcurementStatusRequest;
use App\Models\Procurement;
use App\Models\Category;
use App\Models\Consumable;
use App\Services\ProcurementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ProcurementController extends Controller
{
    public function __construct(
        protected ProcurementService $procurementService
    ) {
    }

    /**
     * Display a listing of procurements.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Base query with security scope
        $query = Procurement::query()
            ->forUser($user)
            ->with('category');

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                    ->orWhere('requestor_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = $request->input('status')) {
            $statusEnum = ProcurementStatus::tryFrom($status);
            if ($statusEnum) {
                $query->where('status', $statusEnum);
            }
        }

        // Statistics (clone query before pagination)
        $statsQuery = $query->clone();
        $totalBudget = $statsQuery->sum(DB::raw('unit_price_estimation * quantity'));
        $countPending = $statsQuery->clone()->pending()->count();

        // Data for admin completion modal
        $consumables = [];
        if ($user->role === 'admin') {
            $consumables = Consumable::whereHas('details', fn($q) => $q->where('current_stock', '>', 0))
                ->withSum('details', 'current_stock')
                ->get();
        }

        // Paginated results
        $requests = $query->latest()->paginate(10);

        return view('pages.procurements.index', compact(
            'requests',
            'totalBudget',
            'countPending',
            'consumables'
        ));
    }

    /**
     * Show the form for creating a new procurement.
     */
    public function create()
    {
        $assetCategories = Category::where('type', 'asset')->orderBy('name')->get();
        $consumableCategories = Category::where('type', 'consumable')->orderBy('name')->get();

        return view('pages.procurements.create', compact('assetCategories', 'consumableCategories'));
    }

    /**
     * Store a newly created procurement.
     */
    public function store(StoreProcurementRequest $request)
    {
        $this->procurementService->create(
            $request->validated(),
            Auth::user()
        );

        return redirect()
            ->route('pengadaan.index')
            ->with('success', 'Usulan pengadaan berhasil dikirim.');
    }

    /**
     * Update the status of a procurement (Approve/Reject/Complete).
     */
    public function updateStatus(UpdateProcurementStatusRequest $request, Procurement $procurement)
    {
        // Authorization via FormRequest
        $validated = $request->validated();
        $status = $validated['status'];

        // Handle REJECTION
        if ($status === 'rejected') {
            $reason = $validated['admin_note'] ?? 'Ditolak';

            if ($this->procurementService->reject($procurement, $reason)) {
                return back()->with('success', 'Usulan pengadaan ditolak.');
            }
            return back()->with('error', 'Gagal menolak usulan.');
        }

        // Handle APPROVAL
        if ($status === 'approved') {
            if ($this->procurementService->approve($procurement, $validated['admin_note'] ?? null)) {
                return back()->with('success', 'Usulan pengadaan disetujui. Silakan lanjutkan proses pembelian.');
            }
            return back()->with('error', 'Gagal menyetujui usulan.');
        }

        // Handle COMPLETION
        if ($status === 'completed') {
            // With stock addition
            if (!empty($validated['consumable_id'])) {
                $success = $this->procurementService->completeWithStock(
                    $procurement,
                    $validated['consumable_id'],
                    $validated['batch_code'],
                    $validated['unit_price'],
                    $validated['admin_note'] ?? null
                );

                if ($success) {
                    return back()->with('success', 'Pengadaan selesai & stok berhasil ditambahkan ke inventaris.');
                }
                return back()->with('error', 'Gagal menyelesaikan pengadaan.');
            }

            // Without stock addition
            if ($this->procurementService->completeWithoutStock($procurement, $validated['admin_note'] ?? null)) {
                return back()->with('success', 'Pengadaan ditandai selesai.');
            }
            return back()->with('error', 'Gagal menyelesaikan pengadaan.');
        }

        return back()->with('error', 'Status tidak valid.');
    }

    /**
     * Remove the specified procurement.
     */
    public function destroy(Procurement $procurement)
    {
        Gate::authorize('delete', $procurement);

        if ($this->procurementService->delete($procurement, Auth::user())) {
            $message = Auth::user()->role === 'admin'
                ? 'Usulan dihapus oleh Admin.'
                : 'Usulan Anda berhasil dibatalkan.';
            return back()->with('success', $message);
        }

        return back()->withErrors(['Gagal! Anda tidak memiliki izin menghapus data ini.']);
    }
}