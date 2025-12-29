<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('inventaris.items', $inventory->category_id) }}"
               class="flex items-center justify-center w-8 h-8 bg-white border rounded-lg text-slate-500 hover:text-indigo-600 hover:border-indigo-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <div class="text-xs uppercase tracking-widest text-slate-500 font-bold">Detail Unit Fisik</div>
                <div class="text-lg font-bold text-slate-800">{{ $inventory->name }}</div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ALERT --}}
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-lg text-sm text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 rounded-lg text-sm text-rose-700">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TOOLBAR --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Daftar Unit</h2>
                    <p class="text-sm text-slate-500">Total {{ $details->total() }} unit</p>
                </div>

                <div class="flex gap-3">
                    <form method="GET" action="{{ route('asset.index', $inventory->id) }}" class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Cari kode / ruangan"
                               class="pl-9 pr-4 py-2 rounded-lg border text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <svg class="absolute left-3 top-2.5 w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </form>

                    <a href="{{ route('asset.create', $inventory->id) }}"
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow">
                        + Tambah Unit
                    </a>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bg-white rounded-xl border overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 text-slate-700 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Model</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4">Sumber Dana</th>
                        <th class="px-6 py-4">Riwayat</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                    </thead>

                    <tbody class="divide-y">
                    @forelse($details as $unit)
                        <tr class="hover:bg-indigo-50/40 transition">
                            {{-- KODE --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-indigo-600 bg-indigo-50 px-2 py-1 rounded text-xs font-bold">
                                    {{ $unit->unit_code }}
                                </span>
                            </td>

                            {{-- MODEL --}}
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $unit->model_name }}
                            </td>

                            {{-- KONDISI --}}
                            <td class="px-6 py-4 text-center">
                                @php
                                    $map = [
                                      'baik' => 'bg-emerald-100 text-emerald-800',
                                      'rusak_ringan' => 'bg-amber-100 text-amber-800',
                                      'rusak_berat' => 'bg-rose-100 text-rose-800'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $map[$unit->condition] }}">
                                    {{ ucfirst(str_replace('_',' ',$unit->condition)) }}
                                </span>
                            </td>

                            {{-- LOKASI --}}
                            <td class="px-6 py-4 font-semibold text-slate-700">
                                {{ $unit->room->name }}
                            </td>

                            {{-- SUMBER --}}
                            <td class="px-6 py-4 text-xs text-slate-600">
                                {{ $unit->fundingSource->name ?? '-' }}
                            </td>

                            {{-- RIWAYAT --}}
                            <td class="px-6 py-4 text-xs text-slate-600 space-y-1">
                                <div><b>Beli:</b> {{ $unit->purchase_date?->format('d M Y') ?? '-' }}</div>
                                <div><b>Perbaikan:</b> {{ $unit->repair_date?->format('d M Y') ?? '-' }}</div>
                                <div><b>Cek:</b> {{ $unit->check_date?->format('d M Y') ?? '-' }}</div>
                            </td>

                            {{-- KET --}}
                            <td class="px-6 py-4 text-xs text-slate-500 italic max-w-[200px] truncate"
                                title="{{ $unit->notes }}">
                                {{ $unit->notes ?? '-' }}
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-center">
                                <x-table.actions>
                                    {{-- EDIT --}}
                                    <x-table.action-link href="{{ route('asset.edit', $unit->id) }}">
                                        ✏️ Edit
                                    </x-table.action-link>

                                    {{-- DISPOSAL --}}
                                    @if($unit->isDisposable())
                                        <x-table.action-link href="{{ route('disposals.create', $unit->id) }}" class="hover:bg-rose-50 text-rose-600 font-bold">
                                            ⚠️ Disposal
                                        </x-table.action-link>
                                    @endif

                                    {{-- DELETE --}}
                                    @if(
                                        $unit->status !== \App\Enums\AssetStatus::DIPINJAM->value &&
                                        !$unit->mutations()->where('status', \App\Enums\MutationStatus::PENDING->value)->exists()
                                    )
                                        <div class="border-t"></div>
                                        <x-table.action-delete 
                                            :action="route('asset.destroy', $unit->id)" 
                                            :confirm="'Hapus permanen unit ' . $unit->unit_code . '?'" 
                                        />
                                    @endif
                                </x-table.actions>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-16 text-slate-400">
                                Belum ada unit terdaftar
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $details->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>