<?php

namespace App\Http\Controllers;

use App\Models\AssetDetail;
use App\Models\ConsumableDetail;
use App\Models\Loan;
use App\Models\Mutation;
use App\Models\Disposal;
use App\Models\Procurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- 1. ACTION CENTER (PENDING APPROVALS) ---
        $pendingMutations = Mutation::where('status', \App\Enums\MutationStatus::PENDING)->count();
        $pendingDisposals = Disposal::where('status', \App\Enums\DisposalStatus::PENDING)->count();
        $pendingProcurements = Procurement::where('status', 'pending')->count();

        // --- 2. FINANCIAL INSIGHTS ---
        $totalAssetValue = AssetDetail::sum('price');

        // --- NEW: INVENTORY STATISTICS ---
        // Total items per category
        $categoryItemCount = DB::table('asset_details')
            ->join('inventories', 'asset_details.inventory_id', '=', 'inventories.id')
            ->join('categories', 'inventories.category_id', '=', 'categories.id')
            ->whereNull('asset_details.deleted_at')
            ->select('categories.name', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.name')
            ->orderByDesc('count')
            ->get();

        // Asset condition distribution (for pie chart)
        $conditionStats = DB::table('asset_details')
            ->whereNull('deleted_at')
            ->select('condition', DB::raw('COUNT(*) as count'))
            ->groupBy('condition')
            ->get()
            ->mapWithKeys(function ($item) {
                $labels = [
                    'baik' => 'Baik',
                    'rusak_ringan' => 'Rusak Ringan',
                    'rusak_berat' => 'Rusak Berat'
                ];
                return [$labels[$item->condition] ?? $item->condition => $item->count];
            });

        // Asset Value by Category
        $assetValueByCategory = DB::table('asset_details')
            ->join('inventories', 'asset_details.inventory_id', '=', 'inventories.id')
            ->join('categories', 'inventories.category_id', '=', 'categories.id')
            ->whereNull('asset_details.deleted_at')
            ->select('categories.name', DB::raw('SUM(asset_details.price) as total_value'))
            ->groupBy('categories.name')
            ->get();

        $chartCategoryLabels = $assetValueByCategory->pluck('name');
        $chartCategoryValues = $assetValueByCategory->pluck('total_value');

        // --- 3. OPERATIONAL METRICS ---
        $totalAssets = AssetDetail::count();
        $activeLoans = Loan::where('status', \App\Enums\LoanStatus::DIPINJAM)->count();
        // Avoid division by zero
        $utilizationRate = $totalAssets > 0 ? round(($activeLoans / $totalAssets) * 100, 1) : 0;

        // --- 4. WARNINGS & ALERTS ---

        // Late Loans
        $lateLoans = Loan::with(['asset.inventory'])
            ->where('status', \App\Enums\LoanStatus::DIPINJAM)
            ->whereDate('return_date_plan', '<', now())
            ->take(5)
            ->get();

        // Low Stock
        $lowStockCount = ConsumableDetail::where('current_stock', '<', 5)
            ->where('current_stock', '>', 0)
            ->count();

        $lowStocks = ConsumableDetail::with('consumable')
            ->where('current_stock', '<', 5)
            ->where('current_stock', '>', 0)
            ->orderBy('current_stock', 'asc')
            ->take(5)
            ->get();

        // Expiring Items
        $expiringItems = ConsumableDetail::with('consumable')
            ->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>', now())
            ->whereDate('expiry_date', '<=', now()->addDays(30))
            ->where('current_stock', '>', 0)
            ->orderBy('expiry_date', 'asc')
            ->take(5)
            ->get();


        // --- 5. CHARTS (EXISTING) ---

        // Loan Trends
        $chartLoans = [];
        $currentYear = date('Y');
        for ($m = 1; $m <= 12; $m++) {
            $count = Loan::whereMonth('loan_date', $m)
                ->whereYear('loan_date', $currentYear)
                ->count();
            $chartLoans[] = $count;
        }

        return view('dashboard', compact(
            'pendingMutations',
            'pendingDisposals',
            'pendingProcurements',
            'totalAssetValue',
            'chartCategoryLabels',
            'chartCategoryValues',
            'categoryItemCount',
            'conditionStats',
            'utilizationRate',
            'activeLoans',
            'lowStockCount',
            'lowStocks',
            'lateLoans',
            'expiringItems',
            'chartLoans'
        ));
    }
}