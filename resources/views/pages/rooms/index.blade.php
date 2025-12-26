<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Manajemen Ruangan
                </h2>
                <p class="text-sm text-gray-500 mt-1">Dashboard monitoring dan pengelolaan fasilitas.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">
                    Updated: {{ now()->format('H:i') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Color-Coded Stats Cards (REVISED) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card Total: Gradient Blue --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Total Aset Ruangan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->total() }}</h3>
                            <span class="text-sm text-indigo-200">Unit</span>
                        </div>
                    </div>
                    {{-- Decorative Icon Background --}}
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 2H5C3.34 2 2 3.34 2 5v14c0 1.66 1.34 3 3 3h14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3zm0 16H5V5h14v13z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
                    </div>
                </div>

                {{-- Card Tersedia: Gradient Emerald --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Siap Digunakan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->where('status', 'tersedia')->count() }}</h3>
                            <span class="text-sm text-emerald-100 bg-white/20 px-2 py-0.5 rounded text-xs">Available</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                </div>

                {{-- Card Perbaikan: Gradient Orange/Red --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-orange-500 to-rose-500 p-6 text-white shadow-lg shadow-orange-200">
                    <div class="relative z-10">
                        <p class="text-orange-100 text-sm font-medium">Dalam Perbaikan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->where('status', 'perbaikan')->count() }}</h3>
                            <span class="text-sm text-orange-100 bg-white/20 px-2 py-0.5 rounded text-xs">Maintenance</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 2. Toolbar & Filters --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                {{-- Search --}}
                <form action="{{ route('ruangan.index') }}" method="GET" class="w-full sm:w-96 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari ruangan..."
                        class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                </form>

                {{-- Action Button --}}
                <a href="{{ route('ruangan.create') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Ruangan
                </a>
            </div>

            {{-- 3. Data Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Detail Ruangan</th>
                                <th class="px-6 py-4">Kepemilikan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Kapasitas</th>
                                <th class="px-6 py-4 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($rooms as $index => $room)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                                    <td class="px-6 py-4 text-center text-gray-400 text-sm font-medium">
                                        {{ $rooms->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            {{-- Updated Icon: Better style --}}
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-200/50 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">
                                                    {{ $room->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                    {{ $room->location }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($room->unit)
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white border border-gray-200 text-gray-700 text-xs font-medium shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                {{ $room->unit->name }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Fasilitas Umum</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'tersedia' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Tersedia'],
                                                'digunakan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Sedang Dipakai'],
                                                'perbaikan' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Maintenance'],
                                            ];
                                            $curr = $statusConfig[$room->status] ?? $statusConfig['tersedia'];
                                        @endphp
                                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $curr['bg'] }} {{ $curr['text'] }} text-xs font-semibold border border-transparent">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $curr['dot'] }}"></span>
                                            {{ $curr['label'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="text-sm text-gray-600 font-mono font-medium bg-gray-50 inline-block px-2 rounded border border-gray-200">
                                            {{ $room->capacity ?? 0 }} <span class="text-gray-400 text-xs font-sans">Org</span>
                                        </div>
                                    </td>
                                    {{-- REVISI: Aksi sekarang terlihat permanen --}}
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- SHOW/DETAIL --}}
                                            <x-table.action-link href="{{ route('ruangan.show', $room->id) }}">
                                                👁️ Lihat Detail
                                            </x-table.action-link>

                                            {{-- EDIT --}}
                                            <x-table.action-link href="{{ route('ruangan.edit', $room->id) }}" class="hover:bg-amber-50 text-amber-600">
                                                ✏️ Edit Data
                                            </x-table.action-link>

                                            {{-- DIVIDER --}}
                                            <div class="border-t"></div>

                                            {{-- DELETE --}}
                                            <x-table.action-delete 
                                                :action="route('ruangan.destroy', $room->id)" 
                                                :confirm="'Hapus ruangan ' . $room->name . ' secara permanen?'"
                                            />
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada data ruangan</h3>
                                        <p class="text-gray-500 mt-1 mb-6 max-w-sm mx-auto text-sm">
                                            Mulailah dengan menambahkan ruangan baru untuk dikelola dalam sistem.
                                        </p>
                                        <a href="{{ route('ruangan.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            + Tambah Ruangan Baru
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($rooms->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $rooms->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>