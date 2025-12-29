<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">BHP /</span>
            <span class="text-slate-800">{{ $category->name }}</span>
        </div>
    </x-slot>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Stok Gudang: {{ $category->name }}</h3>
                    <p class="text-slate-500 mt-1">Kelola item dan monitoring kadaluarsa.</p>
                </div>
                <a href="{{ route('bhp.create', $category->id) }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Registrasi Item Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Barang</th>
                                <th class="px-6 py-4 font-bold">Total Stok</th>
                                <th class="px-6 py-4 font-bold">Satuan</th>
                                <th class="px-6 py-4 font-bold text-rose-600">Exp. Tercepat</th>
                                <th class="px-6 py-4 font-bold">Update Stok Terakhir</th>
                                <th class="px-6 py-4 font-bold">Keterangan</th>
                                <th class="px-6 py-4 font-bold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    {{-- Nama Barang --}}
                                    <td class="px-6 py-4 font-bold text-slate-800 text-base">{{ $item->name }}</td>

                                    {{-- Total Stok --}}
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-blue-100 text-blue-700 text-sm font-bold px-3 py-1 rounded-full border border-blue-200">
                                            {{ $item->total_stock }}
                                        </span>
                                    </td>

                                    {{-- Satuan --}}
                                    <td class="px-6 py-4 text-slate-600">{{ $item->unit }}</td>

                                    {{-- Exp. Tercepat --}}
                                    <td class="px-6 py-4">
                                        @if($item->nearest_expiry)
                                            @php
                                                $expiry = \Carbon\Carbon::parse($item->nearest_expiry);
                                                $isExpired = $expiry->isPast();
                                            @endphp
                                            <span
                                                class="{{ $isExpired ? 'text-rose-600 bg-rose-50' : 'text-slate-600 bg-slate-50' }} font-medium px-2 py-1 rounded border {{ $isExpired ? 'border-rose-200' : 'border-slate-200' }}">
                                                {{ $expiry->format('Y-m-d') }}
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Update Stok Terakhir --}}
                                    <td class="px-6 py-4 text-slate-600">
                                        {{ $item->last_stock_update ? $item->last_stock_update->format('d M Y') : '-' }}
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-6 py-4 text-slate-500 italic max-w-xs truncate">
                                        {{ $item->notes ?? '-' }}
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('consumable.detail', $item->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors"
                                                title="Lihat Detail Stok">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </a>

                                            {{-- Tombol Edit --}}
                                            <a href="{{ route('bhp.edit', $item->id) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200 rounded-lg hover:bg-amber-100 transition-colors"
                                                title="Edit Data Barang">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                    </path>
                                                </svg>
                                            </a>

                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('bhp.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Data stok dan riwayat akan ikut terhapus jika masih kosong.');"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-rose-600 bg-rose-50 border border-rose-200 rounded-lg hover:bg-rose-100 transition-colors"
                                                    title="Hapus Barang">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-slate-500 font-medium">Belum ada barang di kategori ini.</p>
                                        </div>
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