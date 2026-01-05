<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 font-sans pb-20">
        {{-- Header Section --}}
        <header class="bg-white border-b border-gray-200 sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Usulan Pengadaan</h1>
                        <p class="text-sm text-gray-500 mt-1 flex items-center gap-2">
                            <span>Portal Manajemen Aset & Logistik</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="font-medium text-gray-900">{{ now()->format('d M Y') }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('pengadaan.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-900 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900 transition-all shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4"></path>
                            </svg>
                            Buat Usulan Baru
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

            {{-- 1. Modern Stats Cards (Gradient Style) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Pending Requests --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-6 text-white shadow-lg shadow-amber-200">
                    <div class="relative z-10">
                        <p class="text-amber-100 text-sm font-medium">Menunggu Persetujuan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $requests->where('status', 'pending')->count() }}</h3>
                            <span class="text-sm text-amber-100 bg-white/20 px-2 py-0.5 rounded text-xs">Butuh
                                Tindakan</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Total Estimated Value --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Estimasi Anggaran</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">
                                <span
                                    class="text-lg font-normal align-top mr-0.5">Rp</span>{{ number_format($requests->sum(fn($r) => $r->unit_price_estimation * $r->quantity) / 1000000, 1, ',', '.') }}<span
                                    class="text-lg font-normal">jt</span>
                            </h3>
                            <span class="text-sm text-emerald-100 bg-white/20 px-2 py-0.5 rounded text-xs">Total
                                Valuasi</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Total Requests --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Total Usulan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $requests->total() }}</h3>
                            <span class="text-sm text-indigo-100 bg-white/20 px-2 py-0.5 rounded text-xs">Semua
                                Data</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 2. Main Content Area (Unified Filter & Table) --}}
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

                {{-- Toolbar --}}
                <div
                    class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg font-semibold text-gray-800">Daftar Pengajuan</h2>
                        <span
                            class="px-2.5 py-0.5 rounded-full bg-gray-100 text-xs font-medium text-gray-600 border border-gray-200">{{ $requests->total() }}</span>
                    </div>

                    <form action="{{ route('pengadaan.index') }}" method="GET"
                        class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400 group-focus-within:text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari barang..."
                                class="block w-full md:w-64 pl-10 pr-3 py-2 border-gray-300 rounded-lg text-sm placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition-all">
                        </div>

                        <div class="w-full md:w-40">
                            <select name="status" onchange="this.form.submit()"
                                class="block w-full py-2 pl-3 pr-10 border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer bg-white">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                                </option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak
                                </option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                                </option>
                            </select>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50/30">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Info
                                    Pengajuan</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Barang</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Qty</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Valuasi</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse($requests as $req)
                                <tr class="hover:bg-gray-50/60 transition-colors duration-150 group">
                                    {{-- Info Pengajuan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">
                                                {{ substr($req->requestor_name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $req->requestor_name }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $req->created_at->format('d M Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Barang --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col max-w-xs">
                                            <span class="text-sm font-semibold text-gray-900 truncate"
                                                title="{{ $req->item_name }}">{{ $req->item_name }}</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium {{ $req->type == 'asset' ? 'bg-purple-100 text-purple-700' : 'bg-orange-100 text-orange-700' }}">
                                                    {{ $req->type == 'asset' ? 'Aset' : 'BHP' }}
                                                </span>
                                                @if($req->category)
                                                    <span class="text-xs text-gray-500 flex items-center gap-1 truncate">
                                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                        {{ $req->category->name }}
                                                    </span>
                                                @endif
                                            </div>
                                            @if($req->description)
                                                <p class="text-xs text-gray-400 mt-1 truncate max-w-[150px]">
                                                    {{ $req->description }}</p>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Qty --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                            {{ $req->quantity }} Unit
                                        </span>
                                    </td>

                                    {{-- Harga --}}
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        @if($req->unit_price_estimation)
                                            <div class="text-sm font-medium text-gray-900">
                                                Rp
                                                {{ number_format($req->unit_price_estimation * $req->quantity, 0, ',', '.') }}
                                            </div>
                                            <div class="text-[10px] text-gray-400">
                                                @ Rp {{ number_format($req->unit_price_estimation, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">-</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @php
                                            // Konfigurasi tampilan berdasarkan status
                                            $statusStyle = match ($req->status) {
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'completed' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                                default => 'bg-gray-50 text-gray-700 border-gray-200',
                                            };

                                            $statusLabel = match ($req->status) {
                                                'pending' => 'Menunggu',
                                                'approved' => 'Disetujui',
                                                'rejected' => 'Ditolak',
                                                'completed' => 'Selesai',
                                                default => 'Unknown',
                                            };
                                        @endphp

                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $statusStyle }}">
                                            {{-- Logika Ikon SVG --}}
                                            @if($req->status == 'pending')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @elseif($req->status == 'approved')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            @elseif($req->status == 'rejected')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            @elseif($req->status == 'completed')
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            @endif

                                            {{ $statusLabel }}
                                        </div>

                                        @if($req->admin_note)
                                            <div class="group relative inline-block ml-1 align-middle">
                                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{-- Tooltip sederhana --}}
                                                <div
                                                    class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-800 text-white text-[10px] rounded shadow-lg z-10 text-center whitespace-normal">
                                                    {{ $req->admin_note }}
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div
                                            class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">

                                            {{-- APPROVE & REJECT --}}
                                            @if(Auth::user()->role == 'admin' && $req->status == 'pending')
                                                <button
                                                    onclick="openApproveModal('{{ $req->id }}', '{{ $req->item_name }}', '{{ $req->quantity }}', '{{ $req->type }}', '{{ $req->category->name ?? '-' }}')"
                                                    class="p-1.5 rounded-lg text-emerald-600 hover:bg-emerald-50 border border-transparent hover:border-emerald-200 transition-all"
                                                    title="Setujui">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                                <button onclick="openRejectModal({{ $req->id }})"
                                                    class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 border border-transparent hover:border-rose-200 transition-all"
                                                    title="Tolak">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            @endif

                                            {{-- COMPLETE --}}
                                            @if(Auth::user()->role == 'admin' && $req->status == 'approved')
                                                <button
                                                    onclick="openCompleteModal('{{ $req->id }}', '{{ $req->item_name }}', '{{ $req->quantity }}', '{{ $req->unit_price_estimation }}', '{{ $req->type }}', '{{ $req->category->name ?? '-' }}')"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-200 hover:bg-indigo-100 transition-all">
                                                    {{-- Ikon Bendera (Finish) --}}
                                                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 21v-8a2 2 0 012-2h10a2 2 0 012 2v8m2-2a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                                    </svg>
                                                    Selesaikan
                                                </button>
                                            @endif

                                            {{-- DELETE --}}
                                            @if($req->status == 'pending' && (Auth::user()->id == $req->user_id || Auth::user()->role == 'admin'))
                                                <form action="{{ route('pengadaan.destroy', $req->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus usulan ini?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-1.5 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                                                        title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Fallback untuk visual balance jika tidak ada aksi --}}
                                            @if(!(Auth::user()->role == 'admin' && in_array($req->status, ['pending', 'approved'])) && !($req->status == 'pending' && (Auth::user()->id == $req->user_id || Auth::user()->role == 'admin')))
                                                <span class="text-gray-300 text-xs">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div
                                            class="mx-auto h-16 w-16 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-semibold text-gray-900">Belum ada data</h3>
                                        <p class="text-xs text-gray-500 mt-1">Mulai dengan membuat usulan baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $requests->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>

    {{-- Script & Modals (Paste script dan modals JS dari kode sebelumnya di sini tanpa perubahan logika) --}}
    {{-- Saya asumsikan bagian
    <script> dan < div > modal tetap sama, hanya class CSS di dalam modal yang perlu disesuaikan dengan tone baru jika mau--}}

        {
            {
                --Untuk menghemat tempat di sini, pastikan kamu menyertakan kembali blok < script >...</script>
    dan blok Modal di bawah sini dari kodemu yang asli. Logika ID dan Form Action-nya kritikal. --}}
    <script>
            // ... (Paste your existing JS logic here)
            // 1. REJECT LOGIC
            function openRejectModal(id) {
                let reason = prompt("Masukkan alasan penolakan (Wajib diisi):");
                if (reason !== null && reason.trim() !== "") {
                    submitStatusForm(id, 'rejected', reason);
                } else if (reason !== null) {
                    alert("Alasan penolakan tidak boleh kosong.");
                }
            }

            // 2. APPROVE LOGIC (MODAL)
            function openApproveModal(id, itemName, qty, itemType, categoryName) {
                document.getElementById('approve_id').value = id;
                document.getElementById('modal_item_name').innerText = itemName;
                document.getElementById('modal_item_qty').innerText = qty; // removed ' Unit' duplication
                document.getElementById('modal_item_type').innerText = itemType === 'asset' ? 'Aset Tetap' : 'BHP';
                document.getElementById('modal_item_category').innerText = categoryName;
                document.getElementById('approveModal').classList.remove('hidden');
            }

            function closeApproveModal() {
                document.getElementById('approveModal').classList.add('hidden');
            }

            // 3. COMPLETE LOGIC (MODAL)
            function openCompleteModal(id, itemName, qty, price, itemType, categoryName) {
                document.getElementById('complete_id').value = id;
                document.getElementById('modal_complete_item_name').innerText = itemName;
                document.getElementById('modal_complete_item_qty').innerText = qty;
                document.getElementById('modal_complete_item_type').innerText = itemType === 'asset' ? 'Aset Tetap' : 'BHP';
                document.getElementById('modal_complete_item_category').innerText = categoryName;

                let today = new Date().toISOString().slice(0, 10).replace(/-/g, "");
                document.getElementById('batch_code').value = 'PROC-' + id + '-' + today;
                document.getElementById('unit_price').value = price;

                document.getElementById('completeModal').classList.remove('hidden');
            }

            function closeCompleteModal() {
                document.getElementById('completeModal').classList.add('hidden');
            }

            function submitStatusForm(id, status, note = null) {
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/pengadaan/' + id + '/status';
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                let hiddenMethod = document.createElement('input'); hiddenMethod.type = 'hidden'; hiddenMethod.name = '_method'; hiddenMethod.value = 'PUT'; form.appendChild(hiddenMethod);
                let hiddenCsrf = document.createElement('input'); hiddenCsrf.type = 'hidden'; hiddenCsrf.name = '_token'; hiddenCsrf.value = csrfToken; form.appendChild(hiddenCsrf);
                let hiddenStatus = document.createElement('input'); hiddenStatus.type = 'hidden'; hiddenStatus.name = 'status'; hiddenStatus.value = status; form.appendChild(hiddenStatus);
                if (note) {
                    let hiddenNote = document.createElement('input'); hiddenNote.type = 'hidden'; hiddenNote.name = 'admin_note'; hiddenNote.value = note; form.appendChild(hiddenNote);
                }
                document.body.appendChild(form);
                form.submit();
            }
    </script>

    {{-- Sertakan juga blok div Modal Approve & Complete di sini. --}}
    {{-- Tips: Ubah tombol di modal dari warna solid berat ke style yang konsisten dengan tema di atas jika sempat. --}}
    @include('components.modals-procurement')
    {{-- Asumsi saya kamu punya modals terpisah atau paste kode modal lama di sini --}}

</x-app-layout>