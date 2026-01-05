<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">Sirkulasi /</span>
                <span class="text-slate-800 font-bold">Detail Peminjaman</span>
            </div>
            <a href="{{ route('peminjaman.index') }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card Utama -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-200">
                <!-- Header -->
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-start">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800">
                            Peminjaman #{{ $loan->id }}
                        </h3>
                        <p class="text-sm text-slate-500 mt-1">
                            Dibuat pada {{ $loan->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div>
                        @if($loan->status->value == 'kembali')
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Sudah Kembali
                            </span>
                        @elseif($loan->is_overdue)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold bg-rose-50 text-rose-700 border border-rose-100 animate-pulse">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Terlambat
                            </span>
                        @else
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Sedang Dipinjam
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Informasi Peminjam -->
                    <div>
                        <h4
                            class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                            Informasi Peminjam
                        </h4>
                        <div class="bg-indigo-50/50 rounded-xl p-5 border border-indigo-100">
                            <div class="flex items-center gap-4 mb-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-lg">
                                    {{ substr($loan->borrower_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-lg">{{ $loan->borrower_name }}</div>
                                    <div class="text-slate-500 text-sm font-mono">{{ $loan->borrower_id }}</div>
                                </div>
                            </div>
                            @if($loan->notes)
                                <div class="text-sm text-slate-600 bg-white p-3 rounded-lg border border-slate-200 mt-2">
                                    <span class="font-bold block text-xs text-slate-400 mb-1">CATATAN KEPERLUAN:</span>
                                    "{{ $loan->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Aset -->
                    <div>
                        <h4
                            class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                            Aset yang Dipinjam
                        </h4>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs text-slate-500 mb-1">Nama Aset</label>
                                <div class="font-bold text-slate-800">{{ $loan->asset->inventory->name }}</div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Kode Unit</label>
                                    <code
                                        class="text-sm font-mono text-indigo-600 bg-indigo-50 px-2 py-1 rounded inline-block">
                                        {{ $loan->asset->unit_code }}
                                    </code>
                                </div>
                                <div>
                                    <label class="block text-xs text-slate-500 mb-1">Lokasi Asal</label>
                                    <div class="text-sm text-slate-700 font-medium">
                                        {{ $loan->asset->room->name ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline / Rincian Waktu -->
                <div class="px-8 pb-8 pt-0">
                    <h4
                        class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">
                        Timeline Peminjaman
                    </h4>
                    <div class="relative pl-4 border-l-2 border-slate-100 space-y-6">
                        <!-- 1. Tanggal Pinjam -->
                        <div class="relative">
                            <div
                                class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-indigo-500 border-4 border-indigo-100">
                            </div>
                            <h5 class="text-sm font-bold text-slate-800">Mulai Dipinjam</h5>
                            <p class="text-sm text-slate-500">{{ $loan->loan_date->translatedFormat('l, d F Y') }}</p>
                        </div>

                        <!-- 2. Rencana Kembali -->
                        <div class="relative">
                            <div
                                class="absolute -left-[25px] top-1 w-4 h-4 rounded-full {{ $loan->is_overdue && $loan->status->value == 'dipinjam' ? 'bg-rose-500 border-rose-100' : 'bg-slate-300 border-slate-100' }} border-4">
                            </div>
                            <h5 class="text-sm font-bold text-slate-800">Tenggat Pengembalian</h5>
                            <p
                                class="text-sm {{ $loan->is_overdue && $loan->status->value == 'dipinjam' ? 'text-rose-600 font-bold' : 'text-slate-500' }}">
                                {{ $loan->return_date_plan->translatedFormat('l, d F Y') }}
                                @if($loan->is_overdue && $loan->status->value == 'dipinjam')
                                    (Terlambat {{ now()->diffInDays($loan->return_date_plan) }} hari)
                                @endif
                            </p>
                        </div>

                        <!-- 3. Realisasi Kembali (Jika ada) -->
                        @if($loan->status->value == 'kembali')
                            <div class="relative">
                                <div
                                    class="absolute -left-[25px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-emerald-100">
                                </div>
                                <h5 class="text-sm font-bold text-emerald-700">Dikembalikan</h5>
                                <p class="text-sm text-slate-600 mb-1">
                                    {{ $loan->return_date_actual->translatedFormat('l, d F Y') }}</p>

                                <div class="bg-emerald-50 rounded-lg p-3 border border-emerald-100 mt-2">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-xs font-bold text-emerald-800">KONDISI AKHIR:</span>
                                        <span class="text-xs font-bold uppercase
                                                @if($loan->condition_after == 'rusak_berat') text-rose-600
                                                @elseif($loan->condition_after == 'rusak_ringan') text-amber-600
                                                @else text-emerald-600 @endif
                                            ">
                                            {{ str_replace('_', ' ', $loan->condition_after) }}
                                        </span>
                                    </div>
                                    @if($loan->return_notes)
                                        <p class="text-xs text-slate-500 italic">"{{ $loan->return_notes }}"</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>