<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetDetail;
use App\Models\ConsumableDetail;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf; // Panggil Library PDF

class ReportController extends Controller
{
    // HALAMAN MENU LAPORAN
    public function index()
    {
        return view('pages.reports.index');
    }

    // 1. CETAK SEMUA ASET TETAP
    public function printAsset()
    {
        // Ambil semua aset fisik, urutkan berdasarkan Ruangan
        $assets = AssetDetail::with(['inventory.category', 'room', 'fundingSource'])
            ->orderBy('room_id')
            ->get();

        $pdf = Pdf::loadView('pages.reports.pdf_asset', compact('assets'));
        $pdf->setPaper('a4', 'landscape'); // Kertas Landscape biar muat banyak kolom
        return $pdf->stream('Laporan-Aset-Tetap.pdf');
    }

    // 2. CETAK STOK BHP (OBAT/ATK)
    public function printConsumable()
    {
        // Ambil stok yang > 0 saja
        $stocks = ConsumableDetail::with(['consumable', 'room'])
            ->where('current_stock', '>', 0)
            ->orderBy('consumable_id')
            ->get();

        $pdf = Pdf::loadView('pages.reports.pdf_consumable', compact('stocks'));
        return $pdf->stream('Laporan-Stok-BHP.pdf');
    }

    // 3. CETAK PEMINJAMAN AKTIF
    public function printLoan()
    {
        // Ambil yang statusnya DIPINJAM atau TELAT
        $loans = Loan::with(['asset.inventory'])
            ->where('status', \App\Enums\LoanStatus::DIPINJAM)
            ->get();

        $pdf = Pdf::loadView('pages.reports.pdf_loan', compact('loans'));
        return $pdf->stream('Laporan-Peminjaman-Aktif.pdf');
    }
}