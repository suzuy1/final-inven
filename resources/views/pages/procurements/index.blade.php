<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                    Usulan Pengadaan
                </h2>
                <p class="text-sm text-gray-500 mt-1">Portal pengajuan aset dan stok barang unit kerja.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-medium text-gray-600 shadow-sm">
                    {{ now()->format('d M Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. Procurement Stats (Decision Support) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Pending Requests (Priority) --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 p-6 text-white shadow-lg shadow-orange-200">
                    <div class="relative z-10">
                        <p class="text-amber-100 text-sm font-medium">Menunggu Persetujuan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $requests->where('status', 'pending')->count() }}</h3>
                            <span class="text-sm text-amber-100 bg-white/20 px-2 py-0.5 rounded text-xs">Permintaan Baru</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>
                    </div>
                </div>

                {{-- Total Estimated Value --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Total Estimasi Anggaran</p>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-lg font-medium text-emerald-200">Rp</span>
                            {{-- Asumsi Anda bisa menghitung sum dari collection/query --}}
                            <h3 class="text-3xl font-bold">{{ number_format($requests->sum(fn($r) => $r->unit_price_estimation * $r->quantity), 0, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                    </div>
                </div>

                {{-- Total Requests --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 p-6 text-white shadow-lg shadow-indigo-200">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-sm font-medium">Total Usulan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $requests->total() }}</h3>
                            <span class="text-sm text-indigo-200">Item</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 2. Modern Filter Toolbar --}}
            <div class="flex flex-col md:flex-row gap-4 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
                <form action="{{ route('pengadaan.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full">
                    <div class="relative w-full md:w-96 group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari barang, pengusul..."
                            class="block w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm bg-gray-50 focus:bg-white placeholder-gray-400">
                    </div>

                    <div class="w-full md:w-48">
                        <select name="status" onchange="this.form.submit()" 
                            class="block w-full py-2.5 pl-3 pr-10 border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Menunggu</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✅ Disetujui</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Ditolak</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>🏁 Selesai</option>
                        </select>
                    </div>
                    
                    {{-- Reset Filter Button if needed --}}
                    @if(request()->has('search') || request()->has('status'))
                        <a href="{{ route('pengadaan.index') }}" class="inline-flex items-center justify-center px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                            Reset
                        </a>
                    @endif
                </form>

                <div class="w-full md:w-auto ml-auto">
                    <a href="{{ route('pengadaan.create') }}" 
                       class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-semibold text-white text-sm hover:bg-indigo-700 active:bg-indigo-800 transition-all shadow-lg shadow-indigo-500/30 whitespace-nowrap">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Usulan
                    </a>
                </div>
            </div>

            {{-- 3. Data Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4">Tanggal & Pengusul</th>
                                <th class="px-6 py-4">Detail Barang</th>
                                <th class="px-6 py-4 text-center">Qty</th>
                                <th class="px-6 py-4 text-right">Est. Harga</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($requests as $req)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200 group">
                                    {{-- Kolom 1: Meta --}}
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-semibold text-gray-400 mb-0.5">{{ $req->created_at->format('d M Y') }}</span>
                                            <div class="flex items-center gap-2">
                                                <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                                                    {{ substr($req->requestor_name, 0, 2) }}
                                                </div>
                                                <span class="text-sm font-bold text-gray-700">{{ $req->requestor_name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kolom 2: Barang --}}
                                    <td class="px-6 py-4 max-w-xs">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-sm font-bold text-gray-900">{{ $req->item_name }}</span>
                                                <span class="px-1.5 py-0.5 rounded text-[10px] font-bold border {{ $req->type == 'asset' ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-orange-50 text-orange-600 border-orange-100' }}">
                                                    {{ $req->type == 'asset' ? 'Aset' : 'BHP' }}
                                                </span>
                                            </div>
                                            @if($req->description)
                                                <p class="text-xs text-gray-500 truncate" title="{{ $req->description }}">
                                                    {{ $req->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Kolom 3: Qty --}}
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-block bg-gray-100 text-gray-700 text-xs font-bold px-2 py-1 rounded-md">
                                            {{ $req->quantity }}
                                        </span>
                                    </td>

                                    {{-- Kolom 4: Harga --}}
                                    <td class="px-6 py-4 text-right">
                                        @if($req->unit_price_estimation)
                                            <div class="text-sm font-medium text-gray-900">
                                                Rp {{ number_format($req->unit_price_estimation, 0, ',', '.') }}
                                            </div>
                                            <div class="text-[10px] text-gray-400">/unit</div>
                                            <div class="text-xs text-emerald-600 font-bold mt-1">
                                                Total: Rp {{ number_format($req->unit_price_estimation * $req->quantity, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs italic">- Belum ada estimasi -</span>
                                        @endif
                                    </td>

                                    {{-- Kolom 5: Status --}}
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'icon' => '⏳', 'label' => 'Menunggu'],
                                                'approved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'icon' => '✅', 'label' => 'Disetujui'],
                                                'rejected' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'icon' => '❌', 'label' => 'Ditolak'],
                                                'completed' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'border' => 'border-indigo-200', 'icon' => '🏁', 'label' => 'Selesai'],
                                            ];
                                            $curr = $statusConfig[$req->status] ?? $statusConfig['pending'];
                                        @endphp
                                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $curr['bg'] }} {{ $curr['text'] }} border {{ $curr['border'] }} text-xs font-bold">
                                            <span>{{ $curr['icon'] }}</span>
                                            {{ $curr['label'] }}
                                        </div>
                                        @if($req->admin_note)
                                            <div class="group/tooltip relative inline-block mt-1">
                                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-gray-800 text-white text-[10px] rounded shadow-lg opacity-0 invisible group-hover/tooltip:opacity-100 group-hover/tooltip:visible transition-all z-10 text-center">
                                                    "{{ $req->admin_note }}"
                                                    <div class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Kolom 6: Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- APPROVE (ADMIN & PENDING) --}}
                                            @if(Auth::user()->role == 'admin' && $req->status == 'pending')
                                                <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <x-table.action-button type="submit" onclick="return confirm('Setujui usulan ini?')" class="hover:bg-emerald-50 text-emerald-600 font-bold">
                                                        ✅ Setujui Usulan
                                                    </x-table.action-button>
                                                </form>

                                                <x-table.action-button onclick="openRejectModal({{ $req->id }})" class="hover:bg-rose-50 text-rose-600 font-bold">
                                                    ❌ Tolak Usulan
                                                </x-table.action-button>
                                            @endif

                                            {{-- COMPLETE (ADMIN & APPROVED) --}}
                                            @if(Auth::user()->role == 'admin' && $req->status == 'approved')
                                                <form action="{{ route('pengadaan.updateStatus', $req->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="completed">
                                                    <x-table.action-button type="submit" onclick="return confirm('Selesaikan pengadaan ini?')" class="hover:bg-indigo-50 text-indigo-600 font-bold">
                                                        🏁 Selesaikan
                                                    </x-table.action-button>
                                                </form>
                                            @endif

                                            {{-- DELETE (PENDING & OWNER/ADMIN) --}}
                                            @if($req->status == 'pending' && (Auth::user()->id == $req->user_id || Auth::user()->role == 'admin'))
                                                <div class="border-t"></div>
                                                <x-table.action-delete 
                                                    :action="route('pengadaan.destroy', $req->id)"
                                                    confirm="Hapus permanen usulan ini?"
                                                />
                                            @endif

                                            {{-- IF NO ACTIONS --}}
                                            @if(!(Auth::user()->role == 'admin' && in_array($req->status, ['pending', 'approved'])) && !($req->status == 'pending' && (Auth::user()->id == $req->user_id || Auth::user()->role == 'admin')))
                                                <div class="px-4 py-2 text-slate-400 italic">Tidak ada aksi tersedia</div>
                                            @endif
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Tidak ada usulan ditemukan</h3>
                                        <p class="text-gray-500 mt-1 text-sm">Coba sesuaikan filter pencarian atau buat usulan baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($requests->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                        {{ $requests->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script untuk Logic Reject (Tetap menggunakan JS native yang simpel tapi efektif) --}}
    <script>
        function openRejectModal(id) {
            let reason = prompt("Masukkan alasan penolakan (Wajib diisi):");
            if (reason !== null && reason.trim() !== "") {
                // Buat form dinamis
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '/pengadaan/' + id + '/status';
                
                let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                let hiddenMethod = document.createElement('input');
                hiddenMethod.type = 'hidden';
                hiddenMethod.name = '_method';
                hiddenMethod.value = 'PUT';
                form.appendChild(hiddenMethod);

                let hiddenCsrf = document.createElement('input');
                hiddenCsrf.type = 'hidden';
                hiddenCsrf.name = '_token';
                hiddenCsrf.value = csrfToken;
                form.appendChild(hiddenCsrf);

                let hiddenStatus = document.createElement('input');
                hiddenStatus.type = 'hidden';
                hiddenStatus.name = 'status';
                hiddenStatus.value = 'rejected';
                form.appendChild(hiddenStatus);

                let hiddenNote = document.createElement('input');
                hiddenNote.type = 'hidden';
                hiddenNote.name = 'admin_note';
                hiddenNote.value = reason;
                form.appendChild(hiddenNote);

                document.body.appendChild(form);
                form.submit();
            } else if (reason !== null) {
                alert("Alasan penolakan tidak boleh kosong.");
            }
        }
    </script>
</x-app-layout>