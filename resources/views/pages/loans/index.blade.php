<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Sirkulasi Aset
                </h2>
                <p class="text-sm text-gray-500 mt-1">Monitoring peminjaman dan pengembalian aset kantor.</p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">
                    Active Loans: {{ $loans->where('status', 'dipinjam')->count() }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Circulation Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Currently Borrowed --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Sedang Dipinjam</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            {{-- Logic count ini sebaiknya dari controller --}}
                            <h3 class="text-3xl font-bold">{{ $loans->where('status', 'dipinjam')->count() }}</h3>
                            <span class="text-sm text-indigo-200 bg-white/20 px-2 py-0.5 rounded text-xs">Active</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 13h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                </div>

                {{-- Overdue (Critical) --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-6 text-white shadow-lg shadow-rose-200">
                    <div class="relative z-10">
                        <p class="text-rose-100 text-sm font-medium">Terlambat Kembali</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">
                                {{ $loans->where('is_overdue', true)->where('status', 'dipinjam')->count() }}
                            </h3>
                            <span
                                class="text-sm text-rose-100 bg-white/20 px-2 py-0.5 rounded text-xs animate-pulse">Overdue</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" />
                        </svg>
                    </div>
                </div>

                {{-- Returned (History) --}}
                <div
                    class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Sudah Dikembalikan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $loans->where('status', 'kembali')->count() }}</h3>
                            <span
                                class="text-sm text-emerald-100 bg-white/20 px-2 py-0.5 rounded text-xs">Selesai</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- 2. Toolbar & Filter --}}
            <div class="flex flex-col xl:flex-row gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <form action="{{ route('peminjaman.index') }}" method="GET"
                    class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div class="relative group md:col-span-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari peminjam, aset, NIP..."
                            class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                    </div>

                    <div class="md:col-span-1">
                        <select name="status" onchange="this.form.submit()"
                            class="block w-full py-2.5 pl-3 pr-10 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Sedang
                                Dipinjam</option>
                            <option value="kembali" {{ request('status') == 'kembali' ? 'selected' : '' }}>Sudah Kembali
                            </option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat
                            </option>
                        </select>
                    </div>

                    <div class="md:col-span-1">
                        @if(request()->anyFilled(['search', 'status']))
                            <a href="{{ route('peminjaman.index') }}"
                                class="flex items-center justify-center w-full py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>

                <div
                    class="flex items-center gap-2 border-t xl:border-t-0 xl:border-l border-gray-100 pt-4 xl:pt-0 xl:pl-4">
                    <a href="{{ route('peminjaman.create') }}"
                        class="w-full xl:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg shadow-indigo-500/30 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Pinjam Baru
                    </a>
                </div>
            </div>

            {{-- 3. Loan Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 w-40 text-center">Status</th>
                                <th class="px-6 py-4">Aset & Kode</th>
                                <th class="px-6 py-4">Peminjam</th>
                                <th class="px-6 py-4">Durasi Pinjam</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($loans as $loan)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                                    <td class="px-6 py-4 text-center">
                                        @if($loan->status->value == 'kembali')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Selesai
                                            </span>
                                        @elseif($loan->is_overdue)
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100 animate-pulse">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Terlambat
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-100">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Dipinjam
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="font-bold text-gray-900 text-sm">
                                                {{ $loan->asset->inventory->name ?? 'Aset Dihapus' }}
                                            </div>
                                            <code
                                                class="text-xs font-mono text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100 mt-1 inline-block">
                                                            {{ $loan->asset->unit_code ?? '-' }}
                                                        </code>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600 border border-gray-200">
                                                {{ substr($loan->borrower_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-gray-700">{{ $loan->borrower_name }}
                                                </div>
                                                <div class="text-xs text-gray-400 font-mono">{{ $loan->borrower_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <div class="text-xs text-gray-500 flex justify-between">
                                                <span>Pinjam:</span>
                                                <span
                                                    class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M y') }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 flex justify-between">
                                                <span>Tenggat:</span>
                                                <span
                                                    class="font-medium {{ $loan->is_overdue && $loan->status->value == 'dipinjam' ? 'text-rose-600 font-bold' : 'text-gray-700' }}">
                                                    {{ \Carbon\Carbon::parse($loan->return_date_plan)->format('d M y') }}
                                                </span>
                                            </div>
                                            @if($loan->status->value == 'kembali')
                                                <div class="mt-2 pt-2 border-t border-gray-100">
                                                    <div
                                                        class="text-xs text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded border border-emerald-100 w-fit mb-1">
                                                        Kembali:
                                                        {{ \Carbon\Carbon::parse($loan->return_date_actual)->format('d M y') }}
                                                    </div>
                                                    @if($loan->condition_after)
                                                        <div class="text-xs mt-1">
                                                            <span class="text-gray-500">Kondisi:</span>
                                                            <span class="font-bold 
                                                                                        @if($loan->condition_after == 'rusak_berat') text-rose-600
                                                                                        @elseif($loan->condition_after == 'rusak_ringan') text-amber-600
                                                                                        @else text-emerald-600
                                                                                        @endif">
                                                                {{ ucfirst(str_replace('_', ' ', $loan->condition_after)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if($loan->return_notes)
                                                        <div class="text-xs text-gray-600 mt-1 italic">
                                                            "{{ Str::limit($loan->return_notes, 50) }}"
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- RETURN ACTION (IF BORROWED) --}}
                                            @if($loan->status->value == 'dipinjam')
                                                <x-table.action-button
                                                    onclick="openReturnModal({{ $loan->id }}, '{{ $loan->asset->inventory->name }}')"
                                                    class="hover:bg-emerald-50 text-emerald-600 font-bold flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                                    </svg>
                                                    Kembalikan Aset
                                                </x-table.action-button>
                                                <div class="border-t"></div>
                                            @endif

                                            {{-- HISTORY / DETAIL --}}
                                            <a href="{{ route('peminjaman.show', $loan->id) }}" class="flex items-center w-full text-left px-4 py-2 hover:bg-slate-100 text-slate-700 transition-colors">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                Lihat Rincian
                                            </a>
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div
                                            class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Belum ada peminjaman</h3>
                                        <p class="text-gray-500 mt-1 mb-6 text-sm">Data sirkulasi aset akan muncul di sini.
                                        </p>
                                        <a href="{{ route('peminjaman.create') }}"
                                            class="text-indigo-600 font-bold hover:underline text-sm">
                                            + Catat Peminjaman Baru
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $loans->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Return Modal (Modern Style) --}}
    <div id="returnModal"
        class="fixed inset-0 bg-gray-900/60 hidden items-center justify-center z-50 backdrop-blur-sm transition-all duration-300 opacity-0">
        <div class="bg-white p-6 rounded-2xl shadow-2xl w-full max-w-md m-4 transform scale-95 transition-all duration-300"
            id="modalContent">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pengembalian</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <p class="text-sm text-gray-500 mb-6 bg-gray-50 p-3 rounded-lg border border-gray-100">
                Memproses pengembalian aset: <br>
                <span id="modalAssetName" class="font-bold text-gray-800 text-base"></span>
            </p>

            <form id="returnForm" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Kondisi Aset</label>
                    <select name="condition_after" id="conditionSelect"
                        class="w-full border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50">
                        <option value="baik">Baik / Normal</option>
                        <option value="rusak_ringan">Rusak Ringan</option>
                        <option value="rusak_berat">⚠️ Rusak Berat (Aset tidak bisa dipinjam lagi)</option>
                    </select>
                    <div id="warningBox" class="hidden mt-2 p-3 bg-rose-50 border border-rose-200 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                            <div>
                                <p class="text-xs font-bold text-rose-800">PERINGATAN PENTING!</p>
                                <p class="text-xs text-rose-700 mt-1">Aset dengan kondisi <strong>Rusak Berat</strong>
                                    akan otomatis diubah statusnya menjadi <strong>RUSAK</strong> dan <strong>tidak
                                        dapat dipinjam lagi</strong> sampai diperbaiki atau dihapus dari sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-700 mb-1 uppercase">Catatan (Opsional)</label>
                    <textarea name="return_notes" rows="2"
                        class="w-full border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50"
                        placeholder="Keterangan tambahan..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 text-gray-600 text-sm font-bold hover:bg-gray-50 rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-500/30 transition-all">
                        Simpan Pengembalian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReturnModal(id, name) {
            const modal = document.getElementById('returnModal');
            const content = document.getElementById('modalContent');
            const form = document.getElementById('returnForm');
            const nameSpan = document.getElementById('modalAssetName');

            form.action = "/peminjaman/return/" + id;
            nameSpan.textContent = name;

            modal.classList.remove('hidden');
            // Animasi Fade In
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById('returnModal');
            const content = document.getElementById('modalContent');

            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Warning untuk kondisi rusak berat
        document.addEventListener('DOMContentLoaded', function  () {
            const conditionSelect = document.getElementById('conditionSelect');
            const warningBox = document.getElementById('warningBox');

            conditionSelect.addEventListener('change', functio n () {
                if (this.value === 'rusak_berat') {
                    warningBox.classList.remove('hidden');
                    // Animasi shake untuk menarik perhatian
                    warningBox.classList.add('animate-pulse');
                } else {
                    warningBox.classList.add('hidden');
                    warningBox.classList.remove('animate-pulse');
                }
            });
        });
    </script>
</x-app-layout>