<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Manajemen Unit Kerja
                </h2>
                <p class="text-sm text-gray-500 mt-1">Struktur organisasi dan pembagian divisi.</p>
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

            {{-- 1. Stats Cards (Strategic Overview) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Total Units --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Total Unit Kerja</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $units->total() }}</h3>
                            <span class="text-sm text-indigo-200">Divisi</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                    </div>
                </div>

                {{-- Active Units --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Status Aktif</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            {{-- Logic count ini sebaiknya dipass dari controller untuk akurasi jika ada pagination --}}
                            <h3 class="text-3xl font-bold">{{ $units->where('status', 'aktif')->count() }}</h3>
                            <span class="text-sm text-emerald-100 bg-white/20 px-2 py-0.5 rounded text-xs">Operasional</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                </div>

                {{-- Non-Active Units --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-500 to-gray-600 p-6 text-white shadow-lg shadow-gray-200">
                    <div class="relative z-10">
                        <p class="text-gray-100 text-sm font-medium">Non-Aktif / Arsip</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $units->where('status', '!=', 'aktif')->count() }}</h3>
                            <span class="text-sm text-gray-200 bg-white/20 px-2 py-0.5 rounded text-xs">Disbanded</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.59-13L12 10.59 8.41 7 7 8.41 10.59 12 7 15.59 8.41 17 12 13.41 15.59 17 17 15.59 13.41 12 17 8.41z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 2. Toolbar --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <form action="{{ route('unit.index') }}" method="GET" class="w-full sm:w-96 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari nama unit atau kode..."
                        class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                </form>

                <a href="{{ route('unit.create') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Unit
                </a>
            </div>

            {{-- 3. Data Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Nama Unit Kerja</th>
                                <th class="px-6 py-4">Kode Singkatan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($units as $index => $unit)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                                    <td class="px-6 py-4 text-center text-gray-400 text-sm font-medium">
                                        {{ $units->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            {{-- Icon Anchor --}}
                                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-50 to-indigo-100 flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-200/50 shadow-sm">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900">
                                                    {{ $unit->name }}
                                                </div>
                                                @if($unit->description)
                                                    <div class="text-xs text-gray-500 mt-0.5 max-w-xs truncate">
                                                        {{ $unit->description }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($unit->code)
                                            <code class="px-2.5 py-1 rounded-md bg-gray-100 text-indigo-600 font-mono text-xs font-bold border border-gray-200">
                                                {{ $unit->code }}
                                            </code>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($unit->status == 'aktif')
                                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold border border-transparent">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-semibold border border-transparent">
                                                <span class="h-1.5 w-1.5 rounded-full bg-gray-500"></span>
                                                Non-Aktif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- SHOW --}}
                                            <x-table.action-link href="{{ route('unit.show', $unit->id) }}">
                                                👁️ Lihat Detail
                                            </x-table.action-link>

                                            {{-- EDIT --}}
                                            <x-table.action-link href="{{ route('unit.edit', $unit->id) }}" class="hover:bg-amber-50 text-amber-600">
                                                ✏️ Edit Divisi
                                            </x-table.action-link>

                                            {{-- DIVIDER --}}
                                            <div class="border-t"></div>

                                            {{-- DELETE --}}
                                            <x-table.action-delete 
                                                :action="route('unit.destroy', $unit->id)"
                                                confirm="Hapus unit ini? Data aset yang terhubung mungkin akan terpengaruh."
                                                label="Hapus Unit"
                                            />
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada data unit</h3>
                                        <p class="text-gray-500 mt-1 mb-6 max-w-sm mx-auto text-sm">
                                            Silakan tambahkan unit/divisi baru untuk memulai struktur organisasi.
                                        </p>
                                        <a href="{{ route('unit.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                            + Tambah Unit Baru
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($units->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $units->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>