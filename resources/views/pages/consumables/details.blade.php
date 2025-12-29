<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $consumable->name }} /</span>
                <span class="text-slate-800">Kelola Stok</span>
            </div>
<<<<<<< HEAD

            <div class="flex items-center gap-4">
                <a href="{{ route('bhp.items', $consumable->category_id) }}"
                    class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                    &larr; Kembali
                </a>

                <div class="h-4 w-px bg-slate-300"></div>

                {{-- Edit Button --}}
                <a href="{{ route('bhp.edit', $consumable->id) }}"
                    class="inline-flex items-center gap-1 text-sm font-bold text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg border border-amber-200 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Edit
                </a>

                {{-- Delete Button --}}
                <form action="{{ route('bhp.destroy', $consumable->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Data stok dan riwayat akan ikut terhapus jika masih kosong.');"
                    class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center gap-1 text-sm font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg border border-rose-200 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
=======
            <a href="{{ route('bhp.items', $consumable->category_id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali ke Daftar
            </a>
>>>>>>> origin/main
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Riwayat Batch Kedatangan</h3>
                    <p class="text-slate-500 mt-1">Kelola stok masuk, kadaluarsa, dan lokasi penyimpanan untuk <span
                            class="font-bold text-slate-700">{{ $consumable->name }}</span>.</p>
                </div>

                <a href="{{ route('consumable.createBatch', $consumable->id) }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Stok Baru
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 uppercase font-bold text-slate-700 border-b border-slate-100 text-xs">
                            <tr>
                                <th class="px-3 py-3">Kode Batch</th>
                                <th class="px-3 py-3">Merek/Tipe</th>
                                <th class="px-3 py-3 text-blue-600">Tanggal Masuk</th>
                                <th class="px-3 py-3 text-blue-600">Jumlah Masuk</th>
                                <th class="px-3 py-3 text-emerald-600">Stok Tersedia</th>
                                <th class="px-3 py-3 text-rose-600">Tanggal Kadaluwarsa</th>
                                <th class="px-3 py-3">Kondisi</th>
                                <th class="px-3 py-3">Lokasi Penyimpanan</th>
                                <th class="px-3 py-3">Sumber Pendanaan</th>
                                <th class="px-3 py-3">Keterangan</th>
<<<<<<< HEAD
                                <th class="px-3 py-3 text-center">Aksi</th>
=======
>>>>>>> origin/main
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($details as $d)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    {{-- Kode Batch --}}
                                    <td class="px-3 py-3">
                                        <a href="#"
                                            class="font-mono text-blue-600 hover:text-blue-800 hover:underline font-medium text-xs">
                                            {{ $d->batch_code }}
                                        </a>
                                    </td>

                                    {{-- Merek/Tipe --}}
                                    <td class="px-3 py-3 text-slate-800">{{ $d->model_name }}</td>

                                    {{-- Tanggal Masuk --}}
                                    <td class="px-3 py-3 text-blue-600 text-xs whitespace-nowrap">
                                        {{ $d->purchase_date ? \Carbon\Carbon::parse($d->purchase_date)->format('d M Y') : '-' }}
                                    </td>

                                    {{-- Jumlah Masuk --}}
                                    <td class="px-3 py-3">
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full border border-blue-200">
                                            {{ $d->initial_stock }}
                                        </span>
                                    </td>

                                    {{-- Stok Tersedia --}}
                                    <td class="px-3 py-3">
                                        <span
                                            class="bg-emerald-100 text-emerald-700 text-xs font-bold px-2 py-1 rounded-full border border-emerald-200">
                                            {{ $d->current_stock }}
                                        </span>
                                    </td>

                                    {{-- Tanggal Kadaluwarsa --}}
                                    <td class="px-3 py-3">
                                        @if($d->expiry_date)
                                            @php
                                                $expiry = \Carbon\Carbon::parse($d->expiry_date);
                                                $isExpired = $expiry->isPast();
                                            @endphp
                                            <span
                                                class="{{ $isExpired ? 'text-rose-600 bg-rose-50' : 'text-slate-600 bg-slate-50' }} font-medium px-2 py-1 rounded border {{ $isExpired ? 'border-rose-200' : 'border-slate-200' }} text-xs whitespace-nowrap">
                                                {{ $expiry->format('d M Y') }}
                                                @if($isExpired)
                                                    <span class="text-xs">(Expired)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>

                                    {{-- Kondisi --}}
                                    <td class="px-3 py-3">
                                        @if($d->condition == 'baik')
                                            <span
                                                class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 text-xs font-medium px-2 py-1 rounded-full border border-emerald-200">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Baik
                                            </span>
                                        @elseif($d->condition == 'rusak')
                                            <span
                                                class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 text-xs font-medium px-2 py-1 rounded-full border border-orange-200">
                                                ⚠️ Rusak
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 bg-rose-100 text-rose-700 text-xs font-medium px-2 py-1 rounded-full border border-rose-200">
                                                ❌ Kadaluarsa
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Lokasi Penyimpanan --}}
                                    <td class="px-3 py-3 text-slate-600 text-xs">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $d->room->name }}
                                        </div>
                                    </td>

                                    {{-- Sumber Pendanaan --}}
                                    <td class="px-3 py-3">
                                        <span
                                            class="bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded-full border border-blue-200">
                                            {{ $d->fundingSource->code }}
                                        </span>
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-3 py-3 text-slate-600 text-xs max-w-[100px] truncate">
                                        {{ $d->notes ?? '-' }}
                                    </td>
<<<<<<< HEAD

                                    {{-- Aksi --}}
                                    <td class="px-3 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('consumable.editBatch', $d->id) }}"
                                                class="text-amber-600 hover:text-amber-800 bg-amber-50 hover:bg-amber-100 p-1.5 rounded-lg transition-colors"
                                                title="Edit Batch Stok">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                </svg>
                                            </a>
                                            
                                            <form action="{{ route('consumable.destroyBatch', $d->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus batch stok ini? Tindakan ini tidak dapat dibatalkan.');"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-rose-600 hover:text-rose-800 bg-rose-50 hover:bg-rose-100 p-1.5 rounded-lg transition-colors"
                                                    title="Hapus Batch Stok">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
=======
>>>>>>> origin/main
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>