<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <span class="text-slate-400 font-medium text-sm">Inventaris /</span>
            <span class="text-slate-800 font-bold text-xl capitalize tracking-tight">{{ $category->name }}</span>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS & ERROR MESSAGES --}}
            @if(session('success'))
                <div
                    class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 rounded-lg p-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-emerald-800 text-sm">Berhasil!</h4>
                        <p class="text-emerald-700 text-sm mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 rounded-lg p-4 flex items-start gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-rose-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-rose-800 text-sm">Terjadi Kesalahan!</h4>
                        <ul class="text-rose-700 text-sm mt-0.5 list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight">Data Induk Aset</h3>
                    <p class="text-slate-500 mt-2 font-medium">Kelola semua tipe barang dalam kategori
                        {{ $category->name }}.</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                    {{-- SEARCH FORM (Modern Pill Shape) --}}
                    <form action="{{ route('inventaris.items', $category->id) }}" method="GET"
                        class="relative group w-full sm:w-72">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aset..."
                            class="w-full pl-11 pr-4 py-3 bg-white border-0 ring-1 ring-slate-200 rounded-full shadow-sm text-sm focus:ring-2 focus:ring-indigo-500 focus:shadow-md transition-all placeholder:text-slate-400">
                    </form>

                    <a href="{{ route('inventaris.create', $category->id) }}"
                        class="bg-slate-900 text-white px-6 py-3 rounded-full font-semibold text-sm hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>Tambah Aset</span>
                    </a>
                </div>
            </div>

            {{-- TABLE CARD --}}
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-bold">
                                <th class="px-8 py-5">Informasi Aset</th>
                                <th class="px-6 py-5 text-center">Total Unit</th>
                                <th class="px-6 py-5">Kondisi Barang</th>
                                <th class="px-6 py-5 text-right">Kontrol</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($items as $item)
                                <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                    {{-- Kolom Nama & Deskripsi --}}
                                    <td class="px-8 py-5 align-top">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-slate-800 text-lg group-hover:text-indigo-700 transition-colors">
                                                {{ $item->name }}
                                            </span>
                                            <p class="text-slate-500 text-sm mt-1 line-clamp-2 leading-relaxed max-w-xs">
                                                {{ $item->description ?? 'Tidak ada keterangan tambahan.' }}
                                            </p>
                                        </div>
                                    </td>

                                    {{-- Kolom Total Unit --}}
                                    <td class="px-6 py-5 text-center align-top">
                                        <div
                                            class="inline-flex flex-col items-center justify-center bg-slate-100 rounded-2xl px-4 py-2 min-w-[70px]">
                                            <span class="text-2xl font-bold text-slate-800">{{ $item->total_unit }}</span>
                                            <span
                                                class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Unit</span>
                                        </div>
                                    </td>

                                    {{-- Kolom Kondisi (Redesigned: Horizontal Pills) --}}
                                    <td class="px-9 py-5 align-middle">
                                        <div class="flex flex-wrap gap-2 items-center">
                                            {{-- Baik --}}
                                            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-100 px-3 py-1.5 rounded-lg"
                                                title="Kondisi Baik">
                                                <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                                <div class="flex flex-col leading-none">
                                                    <span
                                                        class="text-xs font-bold text-emerald-700">{{ $item->baik ?? 0 }}</span>
                                                    <span class="text-[9px] text-emerald-600 font-medium">Baik</span>
                                                </div>
                                            </div>

                                            {{-- Rusak Ringan --}}
                                            @if(($item->rusak_ringan ?? 0) > 0)
                                                <div class="flex items-center gap-2 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-lg"
                                                    title="Rusak Ringan">
                                                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                                    <div class="flex flex-col leading-none">
                                                        <span
                                                            class="text-xs font-bold text-amber-700">{{ $item->rusak_ringan }}</span>
                                                        <span class="text-[9px] text-amber-600 font-medium">R.Ringan</span>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Rusak Berat --}}
                                            @if(($item->rusak_berat ?? 0) > 0)
                                                <div class="flex items-center gap-2 bg-rose-50 border border-rose-100 px-3 py-1.5 rounded-lg"
                                                    title="Rusak Berat">
                                                    <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                                                    <div class="flex flex-col leading-none">
                                                        <span
                                                            class="text-xs font-bold text-rose-700">{{ $item->rusak_berat }}</span>
                                                        <span class="text-[9px] text-rose-600 font-medium">R.Berat</span>
                                                    </div>
                                                </div>
                                            @endif

                                            @php
                                                // Cek status blocking untuk warning badges
                                                $borrowedCount = $item->details()->where('status', \App\Enums\AssetStatus::DIPINJAM->value)->count();
                                                $pendingMutations = \App\Models\Mutation::whereIn('asset_id', $item->details()->pluck('id'))
                                                    ->where('status', \App\Enums\MutationStatus::PENDING->value)
                                                    ->count();
                                            @endphp

                                            {{-- WARNING: Unit Dipinjam --}}
                                            @if($borrowedCount > 0)
                                                <div class="flex items-center gap-1.5 bg-red-50 border border-red-200 px-2.5 py-1.5 rounded-lg"
                                                    title="Ada {{ $borrowedCount }} unit sedang dipinjam - Tidak dapat dihapus!">
                                                    <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                    <div class="flex flex-col leading-none">
                                                        <span class="text-xs font-bold text-red-700">{{ $borrowedCount }}</span>
                                                        <span class="text-[9px] text-red-600 font-medium">Dipinjam</span>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- WARNING: Mutasi Pending --}}
                                            @if($pendingMutations > 0)
                                                <div class="flex items-center gap-1.5 bg-orange-50 border border-orange-200 px-2.5 py-1.5 rounded-lg"
                                                    title="Ada {{ $pendingMutations }} mutasi pending - Tidak dapat dihapus!">
                                                    <svg class="w-3 h-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <div class="flex flex-col leading-none">
                                                        <span class="text-xs font-bold text-orange-700">{{ $pendingMutations }}</span>
                                                        <span class="text-[9px] text-orange-600 font-medium">Pending</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-5 text-right align-top">
                                        <div class="flex flex-col items-end gap-2">
                                            <div class="flex items-center gap-3">
                                                {{-- Edit Button --}}
                                                <a href="{{ route('inventaris.edit', $item->id) }}"
                                                    class="text-slate-400 hover:text-indigo-600 transition-colors p-2 rounded-full hover:bg-indigo-50"
                                                    title="Edit Data">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>

                                                {{-- Detail Unit Button --}}
                                                <a href="{{ route('asset.index', $item->id) }}"
                                                    class="group/btn inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:border-indigo-600 hover:text-indigo-600 transition-all shadow-sm hover:shadow-md">
                                                    <span>Detail Unit</span>
                                                    <svg class="w-3 h-3 text-slate-400 group-hover/btn:text-indigo-600 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>

                                                {{-- Delete Button with Validation --}}
                                                @php
                                                    // Cek apakah ada unit yang dipinjam
                                                    $borrowedCount = $item->details()->where('status', \App\Enums\AssetStatus::DIPINJAM->value)->count();
                                                    
                                                    // Cek apakah ada mutasi pending
                                                    $pendingMutations = \App\Models\Mutation::whereIn('asset_id', $item->details()->pluck('id'))
                                                        ->where('status', \App\Enums\MutationStatus::PENDING->value)
                                                        ->count();
                                                    
                                                    $canDelete = $borrowedCount === 0 && $pendingMutations === 0;
                                                    $totalUnits = $item->total_unit ?? 0;
                                                @endphp

                                                @if($canDelete)
                                                    <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST"
                                                        onsubmit="return confirm('🚨 PERINGATAN KERAS!\n\n⚠️ Anda akan menghapus PERMANEN:\n📦 Data Induk: {{ $item->name }}\n🔢 Total Unit: {{ $totalUnits }} unit fisik\n\n❌ SEMUA data unit akan HILANG PERMANEN!\n❌ Data tidak dapat dikembalikan!\n\nApakah Anda YAKIN ingin melanjutkan?');"
                                                        class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="text-rose-500 hover:text-rose-700 transition-colors p-2 rounded-full hover:bg-rose-50"
                                                            title="Hapus data induk dan semua unit">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button
                                                        class="text-slate-300 cursor-not-allowed p-2 rounded-full"
                                                        title="Tidak dapat dihapus: {{ $borrowedCount > 0 ? $borrowedCount . ' unit dipinjam' : '' }}{{ $pendingMutations > 0 ? ($borrowedCount > 0 ? ', ' : '') . $pendingMutations . ' mutasi pending' : '' }}"
                                                        disabled>
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                @endif
                                            </div>

                                            {{-- Inline Warning Message (Transparan!) --}}
                                            @if(!$canDelete)
                                                <div class="flex items-start gap-1.5 bg-red-50 border border-red-200 rounded-lg px-3 py-2 max-w-xs">
                                                    <svg class="w-4 h-4 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                    <div class="text-left">
                                                        <p class="text-xs font-bold text-red-800">Tidak dapat dihapus:</p>
                                                        <ul class="text-xs text-red-700 mt-0.5 space-y-0.5">
                                                            @if($borrowedCount > 0)
                                                                <li>• {{ $borrowedCount }} unit dipinjam</li>
                                                            @endif
                                                            @if($pendingMutations > 0)
                                                                <li>• {{ $pendingMutations }} mutasi pending</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-slate-900">Belum ada aset</h3>
                                            <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">
                                                Data untuk kategori ini masih kosong atau pencarian Anda tidak ditemukan.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($items->hasPages())
                    <div class="px-8 py-6 border-t border-slate-100 bg-slate-50/30">
                        {{ $items->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>