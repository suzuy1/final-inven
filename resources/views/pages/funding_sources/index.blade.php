<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Sumber Dana
                </h2>
                <p class="text-sm text-gray-500 mt-1">Master data asal anggaran untuk pengadaan aset.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">
                    Total: {{ $fundings->count() }} Sumber
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Info Cards (Quick Stats) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Card Total --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-slate-700 to-slate-800 p-6 text-white shadow-lg shadow-slate-200">
                    <div class="relative z-10">
                        <p class="text-slate-300 text-sm font-medium">Total Sumber Dana</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $fundings->count() }}</h3>
                            <span class="text-sm text-slate-400">Jalur Anggaran</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-10 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M4 10h12v2H4zm0-4h12v2H4zm0 8h8v2H4zm10 0v6l5.5-3z"></path></svg>
                    </div>
                </div>

                {{-- Card Information (Static Context) --}}
                <div class="relative overflow-hidden rounded-2xl bg-white border border-gray-200 p-6 shadow-sm">
                    <div class="flex items-start gap-4">
                        <div class="h-12 w-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">Petunjuk Penggunaan</h4>
                            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                                Pastikan kode sumber dana unik (contoh: <span class="font-mono text-xs bg-gray-100 px-1 rounded">BOS-2024</span>, <span class="font-mono text-xs bg-gray-100 px-1 rounded">HIBAH-YAYASAN</span>). Data ini akan digunakan saat mencatat aset baru.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. Toolbar --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                {{-- Search Bar (Wajib ada di Controller agar jalan) --}}
                <form action="{{ route('sumber-dana.index') }}" method="GET" class="w-full sm:w-96 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Cari kode atau nama dana..."
                        class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                </form>

                <a href="{{ route('sumber-dana.create') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg shadow-indigo-500/30 whitespace-nowrap">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Data
                </a>
            </div>

            {{-- 3. Data Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 w-48">Kode Referensi</th>
                                <th class="px-6 py-4">Nama Sumber Dana</th>
                                <th class="px-6 py-4 text-center">Tahun/Ket</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($fundings as $funding)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-gray-100 border border-gray-200 text-gray-700 font-mono text-xs font-bold group-hover:bg-indigo-50 group-hover:text-indigo-700 group-hover:border-indigo-100 transition-colors">
                                            <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                                            {{ $funding->code }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div>
                                                <span class="block font-bold text-gray-900">{{ $funding->name }}</span>
                                                @if($funding->description)
                                                    <span class="text-xs text-gray-500 line-clamp-1">{{ $funding->description }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{-- Placeholder jika ada kolom tahun, jika tidak tampilkan dash --}}
                                        <span class="text-sm text-gray-500">{{ $funding->year ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- EDIT --}}
                                            <x-table.action-link href="{{ route('sumber-dana.edit', $funding->id) }}">
                                                ✏️ Edit Data
                                            </x-table.action-link>

                                            {{-- DIVIDER --}}
                                            <div class="border-t"></div>

                                            {{-- DELETE --}}
                                            <x-table.action-delete 
                                                :action="route('sumber-dana.destroy', $funding->id)"
                                                confirm="Apakah Anda yakin? Data aset yang terhubung mungkin akan kehilangan referensi sumber dana."
                                                label="Hapus Data"
                                            />
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada sumber dana</h3>
                                        <p class="text-gray-500 mt-1 mb-6 text-sm">Tambahkan sumber dana untuk mulai mencatat asal usul aset.</p>
                                        <a href="{{ route('sumber-dana.create') }}" class="text-indigo-600 font-bold hover:underline">
                                            + Tambah Baru
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>