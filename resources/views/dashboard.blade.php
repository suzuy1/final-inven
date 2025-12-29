<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Custom Font for Dashboard (Optional override) -->
    <style>
        .font-inter {
            font-family: 'Inter', sans-serif;
        }
    </style>

    <div class="space-y-6 font-inter">

        <!-- Welcome Section & Date -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-slate-500 mt-1">Berikut adalah ringkasan aktivitas inventaris hari ini.</p>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200">
                <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        {{ now()->locale('id')->translatedFormat('l') }}
                    </div>
                    <div class="text-sm font-bold text-slate-700">
                        {{ now()->locale('id')->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. Key Metrics (Clean Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Asset Value -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 bg-slate-50 px-2 py-1 rounded-full">IDR</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-1">
                    {{ number_format($totalAssetValue, 0, ',', '.') }}
                </h3>
                <p class="text-xs text-slate-500 font-medium">Total Nilai Aset</p>
            </div>

            <!-- Utilization Rate -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/10 hover:border-amber-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold {{ $utilizationRate > 50 ? 'text-emerald-600 bg-emerald-50' : 'text-slate-400 bg-slate-50' }} px-2 py-1 rounded-full">
                        {{ $activeLoans }} Item Dipinjam
                    </span>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-1">
                    {{ $utilizationRate }}%
                </h3>
                <p class="text-xs text-slate-500 font-medium">Tingkat Pemanfaatan</p>
            </div>

            <!-- Low Stock Alert -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-rose-500/10 hover:border-rose-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    @if($lowStockCount > 0)
                        <span class="flex h-3 w-3 relative">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                        </span>
                    @endif
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-1">
                    {{ $lowStockCount }}
                </h3>
                <p class="text-xs text-slate-500 font-medium">Stok Menipis</p>
            </div>

            <!-- System Status -->
            <div
                class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-200">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 01-2 2v4a2 2 0 012 2h14a2 2 0 012-2v-4a2 2 0 01-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <span
                        class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Normal</span>
                </div>
                <h3 class="text-2xl font-bold text-emerald-600 mb-1">
                    ONLINE
                </h3>
                <p class="text-xs text-slate-500 font-medium">Status Sistem</p>
            </div>
        </div>

        <!-- 2. Action Center (Pending Items) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending Mutations -->
            <a href="{{ route('mutasi.index') }}"
                class="group block bg-white border border-slate-200 rounded-xl p-5 hover:border-blue-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-blue-100/50 p-3 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700 group-hover:text-blue-600">Mutasi</p>
                            <p class="text-xs text-slate-500">Menunggu Persetujuan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xl font-bold {{ $pendingMutations > 0 ? 'text-blue-600' : 'text-slate-300' }}">{{ $pendingMutations }}</span>
                        @if($pendingMutations > 0)
                            <span class="h-2 w-2 rounded-full bg-blue-500 block"></span>
                        @endif
                    </div>
                </div>
            </a>

            <!-- Pending Disposals -->
            <a href="{{ route('disposals.index') }}"
                class="group block bg-white border border-slate-200 rounded-xl p-5 hover:border-rose-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-rose-100/50 p-3 rounded-lg text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700 group-hover:text-rose-600">Pembuangan</p>
                            <p class="text-xs text-slate-500">Menunggu Persetujuan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xl font-bold {{ $pendingDisposals > 0 ? 'text-rose-600' : 'text-slate-300' }}">{{ $pendingDisposals }}</span>
                        @if($pendingDisposals > 0)
                            <span class="h-2 w-2 rounded-full bg-rose-500 block"></span>
                        @endif
                    </div>
                </div>
            </a>

            <!-- Pending Procurements -->
            <a href="{{ route('pengadaan.index') }}"
                class="group block bg-white border border-slate-200 rounded-xl p-5 hover:border-emerald-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="bg-emerald-100/50 p-3 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-700 group-hover:text-emerald-600">Pengadaan</p>
                            <p class="text-xs text-slate-500">Menunggu Persetujuan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            class="text-xl font-bold {{ $pendingProcurements > 0 ? 'text-emerald-600' : 'text-slate-300' }}">{{ $pendingProcurements }}</span>
                        @if($pendingProcurements > 0)
                            <span class="h-2 w-2 rounded-full bg-emerald-500 block"></span>
                        @endif
                    </div>
                </div>
            </a>
        </div>

        <!-- NEW: Inventory Statistics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Items per Category -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-violet-50 text-violet-600 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800">Item per Kategori</h4>
                    </div>
                    <span class="text-xs font-semibold text-violet-600 bg-violet-50 px-2.5 py-1 rounded-full">
                        {{ $categoryItemCount->sum('count') }} Total
                    </span>
                </div>
                <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                    @forelse($categoryItemCount as $category)
                        @php
                            $maxCount = $categoryItemCount->max('count');
                            $percentage = $maxCount > 0 ? ($category->count / $maxCount) * 100 : 0;
                        @endphp
                        <div class="group">
                            <div class="flex justify-between items-center mb-1.5">
                                <span
                                    class="text-sm font-medium text-slate-700 group-hover:text-violet-600 transition-colors">{{ $category->name }}</span>
                                <span class="text-xs font-bold text-slate-500">{{ $category->count }} item</span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 rounded-full transition-all duration-500 group-hover:from-violet-600 group-hover:to-purple-600"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-sm text-slate-400">Belum ada data kategori</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Condition Distribution Pie Chart -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                <div class="flex items-center justify-between mb-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-cyan-50 text-cyan-600 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-800">Kondisi Aset</h4>
                    </div>
                    <span class="text-xs font-semibold text-cyan-600 bg-cyan-50 px-2.5 py-1 rounded-full">
                        Distribusi
                    </span>
                </div>
                <div id="chart-condition" class="w-full h-64"></div>
            </div>
        </div>

        <!-- 3. Main Content: Charts & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left Column: Charts (2/3) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Chart 1: Asset Value -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-bold text-slate-800">Distribusi Nilai Aset</h4>
                        <button
                            class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1 rounded-lg">
                            Lihat Detail
                        </button>
                    </div>
                    <div id="chart-category" class="w-full h-80"></div>
                </div>

                <!-- Chart 2: Loan Trends -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="font-bold text-slate-800">Tren Peminjaman ({{ date('Y') }})</h4>
                        <select
                            class="text-xs border-slate-200 rounded-lg text-slate-500 focus:ring-indigo-500 focus:border-indigo-500">
                            <option>Tahun Ini</option>
                            <option>Bulan Ini</option>
                        </select>
                    </div>
                    <div id="chart-loans" class="w-full h-72"></div>
                </div>
            </div>

            <!-- Right Column: Quick Items & Alerts (1/3) -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Quick Actions -->
                <div
                    class="bg-gradient-to-br from-indigo-900 to-slate-900 text-white p-6 rounded-xl shadow-lg relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 w-24 h-24 bg-indigo-500/20 rounded-full blur-2xl -ml-12 -mb-12 pointer-events-none">
                    </div>

                    <h4 class="font-bold text-lg mb-4 relative z-10">Aksi Cepat</h4>
                    <div class="space-y-3 relative z-10">
                        <a href="{{ route('inventaris.categories') }}"
                            class="flex items-center gap-3 bg-white/10 hover:bg-white/20 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                            <div class="p-2 bg-indigo-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span class="font-medium text-sm">Tambah Aset Baru</span>
                        </a>

                        <a href="{{ route('peminjaman.create') }}"
                            class="flex items-center gap-3 bg-white/10 hover:bg-white/20 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                            <div class="p-2 bg-purple-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <span class="font-medium text-sm">Aju Peminjaman</span>
                        </a>

                        <a href="{{ route('pengadaan.create') }}"
                            class="flex items-center gap-3 bg-white/10 hover:bg-white/20 p-3 rounded-lg backdrop-blur-sm transition-colors cursor-pointer">
                            <div class="p-2 bg-emerald-500 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <span class="font-medium text-sm">Req. Pengadaan</span>
                        </a>
                    </div>
                </div>

                <!-- Late Loans Alert -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 bg-rose-50 border-b border-rose-100 flex items-center justify-between">
                        <h5 class="font-bold text-rose-700 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Keterlambatan
                        </h5>
                        @if(count($lateLoans) > 0)
                            <span
                                class="bg-rose-200 text-rose-800 text-xs font-bold px-2 py-0.5 rounded-full">{{ count($lateLoans) }}</span>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100 max-h-60 overflow-y-auto">
                        @forelse($lateLoans as $loan)
                            <div class="p-3 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span class="text-xs font-bold text-slate-800">{{ $loan->borrower_name }}</span>
                                    <span class="text-[10px] text-rose-600 font-medium">
                                        {{ \Carbon\Carbon::parse($loan->return_date_plan)->locale('id')->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $loan->asset->inventory->name }}</p>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-xs text-slate-400">Tidak ada peminjaman terlambat.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Expiring Items -->
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                    <div class="p-4 bg-amber-50 border-b border-amber-100 flex items-center justify-between">
                        <h5 class="font-bold text-amber-700 text-sm flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Kadaluarsa
                        </h5>
                        @if(count($expiringItems) > 0)
                            <span
                                class="bg-amber-200 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full">{{ count($expiringItems) }}</span>
                        @endif
                    </div>
                    <div class="divide-y divide-slate-100 max-h-60 overflow-y-auto">
                        @forelse($expiringItems as $item)
                            <div class="p-3 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <span class="text-xs font-bold text-slate-800">{{ $item->consumable->name }}</span>
                                    <span class="text-[10px] text-amber-600 font-medium">
                                        {{ $item->expiry_date->locale('id')->format('d M') }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 mt-0.5">Batch: {{ $item->batch_code }}</p>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-xs text-slate-400">Semua barang aman.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Chart 1: Categories
            var optionsCategory = {
                series: [{
                    name: 'Nilai Aset',
                    data: @json($chartCategoryValues)
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: true,
                        barHeight: '60%',
                        distributed: false
                    }
                },
                colors: ['#4f46e5'], // Indigo 600
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: { colors: ['#fff'], fontSize: '10px' },
                    formatter: function (val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID', { notation: "compact" }).format(val)
                    },
                    offsetX: 0,
                },
                xaxis: {
                    categories: @json($chartCategoryLabels),
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px' }
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#64748b', fontSize: '11px' }
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                        }
                    }
                }
            };
            var chartCategory = new ApexCharts(document.querySelector("#chart-category"), optionsCategory);
            chartCategory.render();

            // Chart 2: Loans (Area Chart)
            var optionsLoans = {
                series: [{
                    name: 'Peminjaman',
                    data: @json($chartLoans)
                }],
                chart: {
                    type: 'area',
                    height: 300,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 2,
                    colors: ['#8b5cf6'] // Violet 500
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 90, 100],
                        colorStops: [
                            {
                                offset: 0,
                                color: "#8b5cf6",
                                opacity: 0.4
                            },
                            {
                                offset: 100,
                                color: "#8b5cf6",
                                opacity: 0
                            }
                        ]
                    }
                },
                markers: { size: 0 },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    labels: { style: { colors: '#94a3b8', fontSize: '11px' } },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    tooltip: { enabled: false }
                },
                yaxis: {
                    labels: { style: { colors: '#94a3b8', fontSize: '11px' } },
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                }
            };
            var chartLoans = new ApexCharts(document.querySelector("#chart-loans"), optionsLoans);
            chartLoans.render();

            // Chart 3: Condition Distribution (Donut Chart)
            var conditionData = @json($conditionStats);
            var optionsCondition = {
                series: Object.values(conditionData),
                labels: Object.keys(conditionData),
                chart: {
                    type: 'donut',
                    height: 256,
                    fontFamily: 'Inter, sans-serif',
                },
                colors: ['#10b981', '#f59e0b', '#f43f5e'], // Emerald, Amber, Rose
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    fontWeight: 600,
                                    color: '#334155'
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#1e293b',
                                    formatter: function (val) {
                                        return val + " unit"
                                    }
                                },
                                total: {
                                    show: true,
                                    label: 'Total Aset',
                                    fontSize: '12px',
                                    color: '#64748b',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0) + " unit"
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 500,
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 3
                    },
                    itemMargin: {
                        horizontal: 12,
                        vertical: 5
                    }
                },
                stroke: {
                    width: 2,
                    colors: ['#fff']
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " unit"
                        }
                    }
                }
            };
            
            if (Object.keys(conditionData).length > 0) {
                var chartCondition = new ApexCharts(document.querySelector("#chart-condition"), optionsCondition);
                chartCondition.render();
            } else {
                document.querySelector("#chart-condition").innerHTML = '<div class="flex items-center justify-center h-full text-slate-400 text-sm">Tidak ada data</div>';
            }
        });
    </script>
</x-app-layout>