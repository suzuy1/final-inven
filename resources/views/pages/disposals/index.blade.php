<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Disposal Aset</h2>
                <p class="text-sm text-slate-500 mt-1">Kelola pengajuan penghapusan aset dengan approval workflow</p>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('disposals.report.pdf') }}" target="_blank"
                    class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Stats Cards --}}
            @if(auth()->user()->role === 'admin')
                @php
                    $totalDisposals = \App\Models\Disposal::count();
                    $approvedCount = \App\Models\Disposal::approved()->count();
                    $rejectedCount = \App\Models\Disposal::rejected()->count();
                    $totalValue = \App\Models\Disposal::approved()->sum('book_value');
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    {{-- Total Disposals --}}
                    <div class="bg-white rounded-lg border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Disposal</h3>
                            <div class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-slate-900">{{ $totalDisposals }}</div>
                        <p class="text-xs text-slate-500 mt-1">Semua pengajuan</p>
                    </div>

                    {{-- Pending --}}
                    <div class="bg-white rounded-lg border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wide">Menunggu Review</h3>
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                            {{ $pendingCount }}
                            @if($pendingCount > 0)
                                <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-1">Butuh tindakan segera</p>
                    </div>

                    {{-- Approved --}}
                    <div class="bg-white rounded-lg border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wide">Disetujui</h3>
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-slate-900">{{ $approvedCount }}</div>
                        <p class="text-xs text-slate-500 mt-1">Telah disetujui</p>
                    </div>

                    {{-- Total Value --}}
                    <div class="bg-white rounded-lg border border-slate-200 p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Nilai</h3>
                            <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalValue / 1000000, 1) }}M</div>
                        <p class="text-xs text-slate-500 mt-1">Nilai disposals disetujui</p>
                    </div>
                </div>
            @endif

            {{-- Search and Filter --}}
            <div class="mb-6 bg-white rounded-lg border border-slate-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="w-full md:w-auto flex-1">
                        <form action="{{ route('disposals.index') }}" method="GET" class="flex gap-4">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari kode aset, nama aset, atau pengusul..."
                                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg text-sm placeholder-slate-400 focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div class="w-full md:w-48">
                                <select name="status" 
                                        onchange="this.form.submit()"
                                        class="block w-full py-2.5 px-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </button>
                        </form>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-600">{{ $disposals->total() }} hasil ditemukan</span>
                        @if(request()->has('search') || request()->has('status'))
                            <a href="{{ route('disposals.index') }}"
                                class="inline-flex items-center gap-1 px-3 py-1.5 text-sm text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-emerald-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 rounded-lg flex items-start gap-3">
                    <svg class="w-5 h-5 text-rose-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            {{-- Table --}}
            <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-3 font-medium">Status</th>
                                <th class="px-6 py-3 font-medium">Aset</th>
                                <th class="px-6 py-3 font-medium">Tipe</th>
                                <th class="px-6 py-3 font-medium">Tanggal</th>
                                <th class="px-6 py-3 font-medium">Pengusul</th>
                                <th class="px-6 py-3 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($disposals as $disposal)
                                <tr class="hover:bg-slate-50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        @if($disposal->status->value == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                @if($pendingCount > 0)
                                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                                @endif
                                                Pending
                                            </span>
                                        @elseif($disposal->status->value == 'approved')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Disetujui
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800 border border-rose-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900">
                                            {{ $disposal->assetDetail->inventory->name ?? 'Item Dihapus' }}
                                        </div>
                                        <div class="text-xs font-mono text-slate-500 mt-0.5">
                                            {{ $disposal->assetDetail->unit_code ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-medium text-slate-700">
                                            {{ $disposal->disposal_type->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-slate-600">
                                            {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y') }}
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($disposal->created_at)->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-700 font-medium text-xs">
                                                {{ substr($disposal->requester->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-slate-900">{{ $disposal->requester->name }}</div>
                                                <div class="text-xs text-slate-500">{{ $disposal->requester->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('disposals.show', $disposal) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-slate-700 hover:text-red-600 hover:bg-slate-100 rounded-lg transition-colors duration-150">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>
                                            
                                            @if(auth()->user()->role === 'admin' && $disposal->status->value == 'pending')
                                                <a href="{{ route('disposals.review', $disposal) }}"
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-rose-700 hover:text-white hover:bg-rose-600 rounded-lg transition-colors duration-150">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                                    </svg>
                                                    Review
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-slate-800 font-medium mb-1">Tidak ada data disposal</h3>
                                            <p class="text-slate-500 text-sm max-w-sm">
                                                @if(request()->has('search') || request()->has('status'))
                                                    Tidak ditemukan disposal yang sesuai dengan kriteria pencarian.
                                                @else
                                                    Belum ada pengajuan disposal dalam sistem.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($disposals->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                        {{ $disposals->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>