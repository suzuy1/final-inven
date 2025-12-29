<x-app-layout>
    {{-- 1. Modern Header with Context --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('ruangan.index') }}" class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm transition-all">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                            {{ $ruangan->name }}
                        </h2>
                        @php
                            $statusConfig = [
                                'tersedia' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'label' => 'Tersedia'],
                                'digunakan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'label' => 'Digunakan'],
                                'perbaikan' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'label' => 'Maintenance'],
                            ];
                            $curr = $statusConfig[$ruangan->status] ?? $statusConfig['tersedia'];
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full {{ $curr['bg'] }} {{ $curr['text'] }} text-xs font-bold border border-transparent">
                            {{ $curr['label'] }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-gray-500 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $ruangan->location }}
                        </span>
                        <span class="text-gray-300">|</span>
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            {{ $ruangan->unit->name ?? 'Fasilitas Umum' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 w-full md:w-auto">
                <button onclick="window.print()" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-white text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold border border-gray-200 hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Laporan
                </button>
                <a href="{{ route('ruangan.edit', $ruangan->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2-2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 2. Vibrant Stats Cards (Gradient Style) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Assets --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Inventaris Aset</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $assets->count() }}</h3>
                            <span class="text-sm text-indigo-200">Item Terdaftar</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/></svg>
                    </div>
                </div>

                {{-- Asset Valuation --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Estimasi Valuasi</p>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-lg font-medium text-emerald-200">Rp</span>
                            <h3 class="text-3xl font-bold">{{ number_format($assets->sum('price'), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                </div>

                {{-- Consumables Stock --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 p-6 text-white shadow-lg shadow-orange-200">
                    <div class="relative z-10">
                        <p class="text-orange-100 text-sm font-medium">Stok Barang Habis Pakai</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $consumables->count() }}</h3>
                            <span class="text-sm text-orange-100 bg-white/20 px-2 py-0.5 rounded text-xs">Batch Aktif</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM6.5 13C4.01 13 2 15.01 2 17.5S4.01 22 6.5 22s4.5-2.01 4.5-4.5S8.99 13 6.5 13zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 3. Split Data Tables --}}
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 print:block">
                
                {{-- Table A: Aset Tetap --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden h-fit print:mb-8 print:border-gray-800">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold text-sm">A</div>
                            <div>
                                <h3 class="font-bold text-gray-900">Aset Tetap</h3>
                                <p class="text-xs text-gray-500">Barang modal & inventaris.</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 font-bold border-b border-gray-100 tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Barang</th>
                                    <th class="px-6 py-4">Merk & Kode</th>
                                    <th class="px-6 py-4 text-center">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($assets as $asset)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $asset->inventory->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">Tahun: {{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->year : '-' }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-gray-700 font-medium">{{ $asset->model_name ?? '-' }}</div>
                                            <code class="text-xs font-mono text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100">{{ $asset->unit_code }}</code>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $condColor = match($asset->condition) {
                                                    'baik' => 'bg-emerald-100 text-emerald-700',
                                                    'rusak-ringan' => 'bg-amber-100 text-amber-700',
                                                    'rusak-berat' => 'bg-rose-100 text-rose-700',
                                                    default => 'bg-gray-100 text-gray-600'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium {{ $condColor }}">
                                                {{ ucfirst(str_replace('-', ' ', $asset->condition)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            <p>Tidak ada data aset tetap.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Table B: BHP --}}
                <div class="bg-white shadow-sm rounded-2xl border border-gray-200 overflow-hidden h-fit print:border-gray-800">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 border border-orange-100 flex items-center justify-center font-bold text-sm">B</div>
                            <div>
                                <h3 class="font-bold text-gray-900">Barang Habis Pakai</h3>
                                <p class="text-xs text-gray-500">Stok opname konsumsi.</p>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 font-bold border-b border-gray-100 tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Barang & Batch</th>
                                    <th class="px-6 py-4 text-center">Sisa Stok</th>
                                    <th class="px-6 py-4 text-right">Kadaluarsa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($consumables as $bhp)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-gray-900">{{ $bhp->consumable->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1 font-mono">
                                                <span class="text-gray-300">#</span>{{ $bhp->batch_code }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="font-bold text-gray-900">{{ $bhp->current_stock }}</span>
                                            <span class="text-xs text-gray-400 ml-1">{{ $bhp->consumable->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($bhp->expiry_date)
                                                @php
                                                    $expDate = \Carbon\Carbon::parse($bhp->expiry_date);
                                                    $isExpired = $expDate->isPast();
                                                    $isNear = $expDate->diffInMonths(now()) < 3 && !$isExpired;
                                                @endphp
                                                @if($isExpired)
                                                    <span class="text-rose-600 font-bold text-xs bg-rose-50 px-2 py-1 rounded border border-rose-100">Expired</span>
                                                    <div class="text-xs text-rose-500 mt-1">{{ $expDate->format('d M Y') }}</div>
                                                @elseif($isNear)
                                                     <span class="text-amber-600 font-bold text-xs bg-amber-50 px-2 py-1 rounded border border-amber-100">Near Exp</span>
                                                     <div class="text-xs text-amber-500 mt-1">{{ $expDate->format('d M Y') }}</div>
                                                @else
                                                    <div class="text-gray-700 font-medium text-xs">{{ $expDate->format('d M Y') }}</div>
                                                @endif
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                            <p>Stok kosong.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>