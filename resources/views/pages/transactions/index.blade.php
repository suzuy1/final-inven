<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Kartu Stok & Mutasi
                </h2>
                <p class="text-sm text-gray-500 mt-1">Log aktivitas keluar-masuk barang habis pakai.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">
                    {{ now()->format('d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Movement Stats (Quick Insight) --}}
            {{-- Note: Pastikan Controller mengirim variabel $summaryIn dan $summaryOut --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Activity --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-700 to-gray-800 p-6 text-white shadow-lg shadow-gray-200">
                    <div class="relative z-10">
                        <p class="text-slate-300 text-sm font-medium">Total Aktivitas</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $transactions->total() }}</h3>
                            <span class="text-sm text-slate-400">Transaksi Log</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-10 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                    </div>
                </div>

                {{-- Inbound --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Barang Masuk (Total)</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            {{-- Placeholder: Ganti dengan variabel dari controller --}}
                            <h3 class="text-3xl font-bold">
                                {{ number_format($summaryIn ?? 0) }}
                            </h3> 
                            <span class="text-sm text-emerald-200 bg-white/20 px-2 py-0.5 rounded text-xs">Stock In</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
                    </div>
                </div>

                {{-- Outbound --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-6 text-white shadow-lg shadow-rose-200">
                    <div class="relative z-10">
                        <p class="text-rose-100 text-sm font-medium">Barang Keluar (Total)</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            {{-- Placeholder: Ganti dengan variabel dari controller --}}
                            <h3 class="text-3xl font-bold">
                                {{ number_format($summaryOut ?? 0) }}
                            </h3>
                            <span class="text-sm text-rose-100 bg-white/20 px-2 py-0.5 rounded text-xs">Stock Out</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 13H5v-2h14v2z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 2. Advanced Filter & Action Toolbar --}}
            <div class="flex flex-col xl:flex-row gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <form action="{{ route('transaksi.index') }}" method="GET" class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3">
                    {{-- Search --}}
                    <div class="relative group md:col-span-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang / batch..." class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                    </div>

                    {{-- Type Filter --}}
                    <div class="md:col-span-1">
                        <select name="type" onchange="this.form.submit()" class="block w-full py-2.5 pl-3 pr-10 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="">Semua Jenis Mutasi</option>
                            <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>📥 Stok Masuk</option>
                            <option value="keluar" {{ request('type') == 'keluar' ? 'selected' : '' }}>📤 Stok Keluar</option>
                        </select>
                    </div>

                    {{-- Date Range --}}
                    <div class="md:col-span-2 flex gap-2">
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-gray-50 focus:bg-white text-gray-600">
                        <span class="self-center text-gray-400">-</span>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 bg-gray-50 focus:bg-white text-gray-600">
                        
                        <button type="submit" class="px-3 bg-gray-800 text-white rounded-xl hover:bg-gray-900 transition-colors shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>
                        
                        @if(request()->anyFilled(['search', 'type', 'start_date', 'end_date']))
                            <a href="{{ route('transaksi.index') }}" class="px-3 flex items-center justify-center border border-rose-200 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-colors" title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>

                <div class="flex items-center gap-2 border-t xl:border-t-0 xl:border-l border-gray-100 pt-4 xl:pt-0 xl:pl-4">
                    <a href="{{ route('transaksi.create') }}" class="w-full xl:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-rose-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-rose-700 active:bg-rose-800 transition-all shadow-lg shadow-rose-500/30 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4m0 0l6-6m-6 6l6 6"></path></svg>
                        Catat Barang Keluar
                    </a>
                </div>
            </div>

            {{-- 3. Transaction Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4">Waktu</th>
                                <th class="px-6 py-4">Item & Batch</th>
                                <th class="px-6 py-4 text-center">Jenis Mutasi</th>
                                <th class="px-6 py-4 text-right">Jumlah</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Petugas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($transactions as $t)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-700 text-sm">{{ \Carbon\Carbon::parse($t->date)->format('d M Y') }}</span>
                                            <span class="text-xs text-gray-400 mt-0.5 font-mono">{{ \Carbon\Carbon::parse($t->created_at)->format('H:i') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm">{{ $t->detail->consumable->name ?? 'Item Dihapus' }}</div>
                                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-mono font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                                    #{{ $t->detail->batch_code ?? 'N/A' }}
                                                </span>
                                                @if($t->detail->expiry_date)
                                                    @php
                                                        $isExpired = \Carbon\Carbon::parse($t->detail->expiry_date)->isPast();
                                                    @endphp
                                                    <span class="text-[10px] {{ $isExpired ? 'text-rose-500 font-bold' : 'text-gray-400' }}">
                                                        Exp: {{ $t->detail->expiry_date }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->type->value == 'masuk')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                                Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end">
                                            <span class="text-lg font-bold font-mono {{ $t->type->value == 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                                {{ $t->type->value == 'masuk' ? '+' : '-' }}{{ $t->amount }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $t->detail->consumable->unit ?? 'Unit' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-600 text-xs italic leading-relaxed max-w-xs truncate" title="{{ $t->notes }}">
                                            {{ $t->notes ?: '-' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <div class="text-right">
                                                <div class="text-xs font-bold text-gray-700">{{ $t->user->name ?? 'System' }}</div>
                                                <div class="text-[10px] text-gray-400">Petugas</div>
                                            </div>
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold border border-gray-300">
                                                {{ substr($t->user->name ?? 'S', 0, 1) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada riwayat transaksi</h3>
                                        <p class="text-gray-500 mt-1 text-sm">Data mutasi barang akan muncul di sini setelah ada aktivitas.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($transactions->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $transactions->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>