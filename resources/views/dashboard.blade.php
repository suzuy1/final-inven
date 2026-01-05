@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', 'Figtree', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease-out forwards; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .stat-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover { transform: translateY(-4px) scale(1.02); }
        .chart-container { position: relative; overflow: hidden; }
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            opacity: 0; transition: opacity 0.3s;
        }
        .chart-container:hover::before { opacity: 1; }
    </style>
@endpush

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <div>
                <h2 class="font-black text-2xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">
                    {{ __('Command Center') }}
                </h2>
                <p class="text-sm text-slate-500 mt-1">Real-time inventory intelligence dashboard</p>
            </div>
            <div class="text-right">
                <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ now()->format('l') }}</div>
                <div class="text-sm font-bold text-slate-700">{{ now()->format('d F Y') }}</div>
            </div>
        </div>
    </x-slot>

    <!-- Hero Background Gradient -->
    <div class="fixed top-0 left-0 right-0 h-96 bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 -z-10"></div>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- 1. ACTION CENTER (PENDING APPROVALS) -->
            <section class="animate-fade-in-up" style="animation-delay: 0.1s; opacity: 0;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Action Center</h3>
                        <p class="text-sm text-slate-500">Pending approvals requiring your attention</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pending Mutations -->
                    <a href="{{ route('mutasi.index') }}"
                        class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 p-[2px] hover:shadow-2xl hover:shadow-blue-500/50 transition-all duration-500 stat-card">
                        <div class="bg-white rounded-[22px] p-6 h-full relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 opacity-5 group-hover:opacity-10 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="text-blue-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <div
                                        class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    @if($pendingMutations > 0)
                                        <span class="flex h-3 w-3 relative">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pending
                                    Mutations</p>
                                <h4
                                    class="text-4xl font-black {{ $pendingMutations > 0 ? 'bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent' : 'text-slate-700' }} mb-4">
                                    {{ $pendingMutations }}
                                </h4>

                                <div
                                    class="flex items-center text-sm font-bold text-blue-600 group-hover:translate-x-2 transition-transform">
                                    Review Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Disposals -->
                    <a href="{{ route('disposals.index') }}"
                        class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-rose-500 to-rose-600 p-[2px] hover:shadow-2xl hover:shadow-rose-500/50 transition-all duration-500 stat-card">
                        <div class="bg-white rounded-[22px] p-6 h-full relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 opacity-5 group-hover:opacity-10 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="text-rose-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <div
                                        class="p-3 bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </div>
                                    @if($pendingDisposals > 0)
                                        <span class="flex h-3 w-3 relative">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pending
                                    Disposals</p>
                                <h4
                                    class="text-4xl font-black {{ $pendingDisposals > 0 ? 'bg-gradient-to-r from-rose-600 to-rose-700 bg-clip-text text-transparent' : 'text-slate-700' }} mb-4">
                                    {{ $pendingDisposals }}
                                </h4>

                                <div
                                    class="flex items-center text-sm font-bold text-rose-600 group-hover:translate-x-2 transition-transform">
                                    Review Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <!-- Pending Procurements -->
                    <a href="{{ route('pengadaan.index') }}"
                        class="group relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-[2px] hover:shadow-2xl hover:shadow-emerald-500/50 transition-all duration-500 stat-card">
                        <div class="bg-white rounded-[22px] p-6 h-full relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-32 h-32 opacity-5 group-hover:opacity-10 transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="text-emerald-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-4">
                                    <div
                                        class="p-3 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg group-hover:scale-110 transition-transform">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    @if($pendingProcurements > 0)
                                        <span class="flex h-3 w-3 relative">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                        </span>
                                    @endif
                                </div>

                                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pending
                                    Procurements</p>
                                <h4
                                    class="text-4xl font-black {{ $pendingProcurements > 0 ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent' : 'text-slate-700' }} mb-4">
                                    {{ $pendingProcurements }}
                                </h4>

                                <div
                                    class="flex items-center text-sm font-bold text-emerald-600 group-hover:translate-x-2 transition-transform">
                                    Review Now
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </section>

            <!-- 2. OPERATIONAL METRICS -->
            <section class="animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0;">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 bg-gradient-to-br from-violet-500 to-purple-600 rounded-lg shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800">Operational Metrics</h3>
                        <p class="text-sm text-slate-500">Key performance indicators at a glance</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total Asset Value -->
                    <div
                        class="glass-card p-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 stat-card border-2 border-white/50">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Total Asset Value</p>
                        <h4 class="text-2xl font-black text-slate-800 mb-1">Rp
                            {{ number_format($totalAssetValue, 0, ',', '.') }}</h4>
                        <p class="text-xs text-slate-400">Across all categories</p>
                    </div>

                    <!-- Utilization Rate -->
                    <div
                        class="glass-card p-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 stat-card border-2 border-white/50">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Utilization Rate</p>
                        <h4 class="text-2xl font-black text-slate-800 mb-1">{{ $utilizationRate }}%</h4>
                        <p class="text-xs text-slate-400">{{ $activeLoans }} items on loan</p>
                    </div>

                    <!-- Low Stock Alerts -->
                    <div
                        class="glass-card p-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 stat-card border-2 border-white/50">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Low Stock Alerts</p>
                        <h4 class="text-2xl font-black text-slate-800 mb-1">{{ $lowStockCount }}</h4>
                        <p class="text-xs text-slate-400">Items below threshold</p>
                    </div>

                    <!-- System Status -->
                    <div
                        class="glass-card p-6 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300 stat-card border-2 border-white/50">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">System Status</p>
                        <h4
                            class="text-2xl font-black bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent mb-1">
                            ONLINE</h4>
                        <p class="text-xs text-slate-400">All services operational</p>
                    </div>
                </div>
            </section>

            <!-- 3. INVENTORY STATISTICS -->
            <section class="animate-fade-in-up" style="animation-delay: 0.3s; opacity: 0;">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Items per Category -->
                    <div class="glass-card p-8 rounded-3xl shadow-xl border-2 border-white/50">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-violet-100 text-violet-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h4 class="font-black text-slate-800">Items per Category</h4>
                            </div>
                            <span class="text-xs font-bold text-violet-600 bg-violet-50 px-3 py-1 rounded-full">
                                {{ $categoryItemCount->sum('count') }} Total
                            </span>
                        </div>
                        <div class="space-y-4 max-h-72 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($categoryItemCount as $category)
                                @php
                                    $maxCount = $categoryItemCount->max('count');
                                    $percentage = $maxCount > 0 ? ($category->count / $maxCount) * 100 : 0;
                                @endphp
                                <div class="group">
                                    <div class="flex justify-between items-center mb-2">
                                        <span
                                            class="text-sm font-bold text-slate-700 group-hover:text-violet-600 transition-colors">{{ $category->name }}</span>
                                        <span class="text-xs font-black text-slate-500">{{ $category->count }} items</span>
                                    </div>
                                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200/50">
                                        <div class="h-full bg-gradient-to-r from-violet-500 to-purple-500 rounded-full transition-all duration-1000 group-hover:from-violet-600 group-hover:to-purple-600 shadow-sm"
                                            style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-sm font-bold text-slate-400 italic">No category data available</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Condition Distribution -->
                    <div class="glass-card p-8 rounded-3xl shadow-xl border-2 border-white/50">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 bg-cyan-100 text-cyan-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                    </svg>
                                </div>
                                <h4 class="font-black text-slate-800">Asset Condition</h4>
                            </div>
                            <span class="text-xs font-bold text-cyan-600 bg-cyan-50 px-3 py-1 rounded-full">
                                Distribution
                            </span>
                        </div>
                        <div id="chart-condition" class="w-full h-72"></div>
                    </div>
                </div>
            </section>

            <!-- 4. QUICK ACTIONS -->
            <section class="animate-fade-in-up" style="animation-delay: 0.4s; opacity: 0;">
                <div
                    class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 p-8 shadow-2xl">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 opacity-20">
                        <div
                            class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse">
                        </div>
                        <div class="absolute top-0 -right-4 w-72 h-72 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"
                            style="animation-delay: 2s;"></div>
                        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"
                            style="animation-delay: 4s;"></div>
                    </div>

                    <div class="relative z-10">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                            <div>
                                <h3 class="text-2xl font-black text-white mb-2">Quick Actions</h3>
                                <p class="text-purple-200 text-sm">Fast access to common inventory tasks</p>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('inventaris.categories') }}"
                                    class="group px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 rounded-xl font-bold text-sm text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    Add Asset
                                </a>
                                <a href="{{ route('peminjaman.create') }}"
                                    class="group px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl font-bold text-sm text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-2 border border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    New Loan
                                </a>
                                <a href="{{ route('pengadaan.create') }}"
                                    class="group px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-xl font-bold text-sm text-white shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex items-center gap-2 border border-white/20">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Request Procurement
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 5. CHARTS & ALERTS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column: Charts -->
                <div class="lg:col-span-2 space-y-6 animate-fade-in-up" style="animation-delay: 0.5s; opacity: 0;">
                    <!-- Asset Category Breakdown -->
                    <div class="glass-card p-8 rounded-3xl shadow-xl border-2 border-white/50 chart-container">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-black text-slate-800">Asset Value by Category</h3>
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">Live
                                Data</span>
                        </div>
                        <div id="chart-category" class="w-full h-80"></div>
                    </div>

                    <!-- Loan Trends -->
                    <div class="glass-card p-8 rounded-3xl shadow-xl border-2 border-white/50 chart-container">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-black text-slate-800">Loan Trends ({{ date('Y') }})</h3>
                            <span
                                class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">Monthly</span>
                        </div>
                        <div id="chart-loans" class="w-full h-80"></div>
                    </div>
                </div>

                <!-- Right Column: Urgent Attention -->
                <div class="space-y-6 animate-fade-in-up" style="animation-delay: 0.6s; opacity: 0;">
                    <!-- Overdue Loans -->
                    <div class="glass-card rounded-3xl shadow-xl overflow-hidden border-2 border-white/50">
                        <div class="p-5 bg-gradient-to-r from-rose-500 to-pink-600">
                            <h3 class="font-black text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Overdue Loans
                            </h3>
                            <p class="text-rose-100 text-xs mt-1">Items past return date</p>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                            @forelse($lateLoans as $loan)
                                <div
                                    class="p-4 hover:bg-gradient-to-r hover:from-rose-50 hover:to-pink-50 transition-all duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-bold text-slate-800 text-sm">{{ $loan->borrower_name }}</span>
                                        <span class="text-xs font-black text-rose-600 bg-rose-100 px-3 py-1 rounded-full">
                                            {{ \Carbon\Carbon::parse($loan->return_date_plan)->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 font-medium">{{ $loan->asset->inventory->name }}</p>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div class="inline-flex p-4 bg-emerald-100 rounded-full mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 text-sm font-semibold">No overdue loans</p>
                                    <p class="text-slate-400 text-xs">Great job keeping track!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Expiring Consumables -->
                    <div class="glass-card rounded-3xl shadow-xl overflow-hidden border-2 border-white/50">
                        <div class="p-5 bg-gradient-to-r from-amber-500 to-orange-600">
                            <h3 class="font-black text-white flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                Expiring Soon
                            </h3>
                            <p class="text-amber-100 text-xs mt-1">Consumables nearing expiry</p>
                        </div>
                        <div class="divide-y divide-slate-100 max-h-96 overflow-y-auto">
                            @forelse($expiringItems as $item)
                                <div
                                    class="p-4 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-all duration-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-bold text-slate-800 text-sm">{{ $item->consumable->name }}</span>
                                        <span class="text-xs font-black text-amber-600 bg-amber-100 px-3 py-1 rounded-full">
                                            {{ $item->expiry_date->format('d M') }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-slate-600 font-medium">Batch: {{ $item->batch_code }}</p>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div class="inline-flex p-4 bg-emerald-100 rounded-full mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-slate-500 text-sm font-semibold">All items fresh</p>
                                    <p class="text-slate-400 text-xs">No items expiring soon</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Chart 1: Asset Value by Category
            var optionsCategory = {
                series: [{
                    name: 'Total Value',
                    data: @json($chartCategoryValues)
                }],
                chart: {
                    type: 'bar',
                    height: 320,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        horizontal: true,
                        barHeight: '70%',
                        distributed: true,
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    textAnchor: 'start',
                    style: { colors: ['#fff'], fontSize: '12px', fontWeight: 700 },
                    formatter: function (val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                    },
                    offsetX: 10,
                },
                xaxis: {
                    categories: @json($chartCategoryLabels),
                    labels: { style: { fontSize: '12px', fontWeight: 600, colors: '#64748b' } }
                },
                colors: ['#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f97316', '#eab308', '#22c55e', '#06b6d4', '#3b82f6'],
                legend: { show: false },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: false } }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val)
                        }
                    }
                }
            };

            if (document.querySelector("#chart-category")) {
                var chartCategory = new ApexCharts(document.querySelector("#chart-category"), optionsCategory);
                chartCategory.render();
            }

            // Chart 2: Loan Trends
            var optionsLoans = {
                series: [{
                    name: 'Loans',
                    data: @json($chartLoans)
                }],
                chart: {
                    height: 320,
                    type: 'area',
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                dataLabels: { enabled: false },
                stroke: { curve: 'smooth', width: 3, colors: ['#8b5cf6'] },
                markers: {
                    size: 5,
                    colors: ['#8b5cf6'],
                    strokeColors: '#fff',
                    strokeWidth: 2,
                    hover: { size: 7 }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    labels: { style: { colors: '#64748b', fontSize: '12px', fontWeight: 600 } }
                },
                yaxis: {
                    labels: { style: { colors: '#64748b', fontSize: '12px', fontWeight: 600 } }
                },
                colors: ['#8b5cf6'],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        gradientToColors: ['#ec4899'],
                        inverseColors: false,
                        opacityFrom: 0.6,
                        opacityTo: 0.1,
                        stops: [0, 100]
                    }
                },
                grid: {
                    borderColor: '#f1f5f9',
                    strokeDashArray: 4,
                    yaxis: { lines: { show: true } },
                    xaxis: { lines: { show: false } }
                },
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return val + ' loans'
                        }
                    }
                }
            };

            if (document.querySelector("#chart-loans")) {
                var chartLoans = new ApexCharts(document.querySelector("#chart-loans"), optionsLoans);
                chartLoans.render();
            }

            // Chart 3: Condition Distribution (Donut Chart)
            var conditionData = @json($conditionStats);
            var optionsCondition = {
                series: Object.values(conditionData),
                labels: Object.keys(conditionData),
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'Inter, sans-serif',
                },
                colors: ['#10b981', '#f59e0b', '#f43f5e', '#6366f1', '#8b5cf6'], // Emerald, Amber, Rose + Indigo, Violet
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: {
                                    show: true,
                                    fontSize: '14px',
                                    fontWeight: 700,
                                    color: '#64748b'
                                },
                                value: {
                                    show: true,
                                    fontSize: '28px',
                                    fontWeight: 900,
                                    color: '#1e293b',
                                    formatter: function (val) { return val }
                                },
                                total: {
                                    show: true,
                                    label: 'Total Assets',
                                    fontSize: '12px',
                                    fontWeight: 600,
                                    color: '#94a3b8',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                legend: {
                    position: 'bottom',
                    fontSize: '12px',
                    fontWeight: 600,
                    markers: { radius: 6 },
                    itemMargin: { horizontal: 10, vertical: 5 }
                },
                stroke: { width: 4, colors: ['#fff'] },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function(val) { return val + " units" } }
                }
            };
            
            if (Object.keys(conditionData).length > 0 && document.querySelector("#chart-condition")) {
                var chartCondition = new ApexCharts(document.querySelector("#chart-condition"), optionsCondition);
                chartCondition.render();
            } else if(document.querySelector("#chart-condition")) {
                document.querySelector("#chart-condition").innerHTML = '<div class="flex items-center justify-center h-full text-slate-400 font-bold italic">No condition data</div>';
            }
        });
    </script>
</x-app-layout>
