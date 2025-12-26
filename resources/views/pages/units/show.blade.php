<x-app-layout>
    {{-- 1. Enhanced Header --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('unit.index') }}" class="group flex items-center justify-center w-10 h-10 bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-sm transition-all">
                    <svg class="w-5 h-5 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center gap-2">
                        {{ $unit->name }}
                        @if($unit->code)
                            <span class="px-2 py-0.5 rounded-lg bg-gray-100 text-gray-600 text-sm font-mono border border-gray-200">
                                {{ $unit->code }}
                            </span>
                        @endif
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Detail divisi dan alokasi ruangan.</p>
                </div>
            </div>

            <div class="flex gap-2 w-full md:w-auto">
                <a href="{{ route('unit.edit', $unit->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2-2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Unit
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 2. Unit Health Stats (Gradient Cards) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Total Scope --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-violet-600 to-purple-600 p-6 text-white shadow-lg shadow-violet-200">
                    <div class="relative z-10">
                        <p class="text-violet-100 text-sm font-medium">Total Ruangan</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->count() }}</h3>
                            <span class="text-sm text-violet-200">Unit Terdaftar</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M17 10.07L2 2.5V12h15V10.07zM17 13.93L2 21.5V14h15v-0.07zM19 12h5v2h-5z"/></svg>
                    </div>
                </div>

                {{-- Operational --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white shadow-lg shadow-emerald-200">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-sm font-medium">Ruangan Siap Pakai</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->where('status', 'tersedia')->count() }}</h3>
                            <span class="text-sm text-emerald-100 bg-white/20 px-2 py-0.5 rounded text-xs">Available</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                </div>

                {{-- Maintenance/Issues --}}
                <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 p-6 text-white shadow-lg shadow-rose-200">
                    <div class="relative z-10">
                        <p class="text-rose-100 text-sm font-medium">Butuh Perhatian</p>
                        <div class="flex items-baseline gap-2 mt-2">
                            <h3 class="text-3xl font-bold">{{ $rooms->where('status', '!=', 'tersedia')->count() }}</h3>
                            <span class="text-sm text-rose-100 bg-white/20 px-2 py-0.5 rounded text-xs">Maintenance/Used</span>
                        </div>
                    </div>
                    <div class="absolute -right-2 -bottom-4 opacity-20 transform rotate-12">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
                    </div>
                </div>
            </div>

            {{-- 3. Room List Table --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center font-bold text-sm">R</div>
                        <div>
                            <h3 class="font-bold text-gray-900">Daftar Lokasi & Ruangan</h3>
                            <p class="text-xs text-gray-500">Ruangan yang dikelola oleh unit ini.</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4 w-16 text-center">No</th>
                                <th class="px-6 py-4">Detail Ruangan</th>
                                <th class="px-6 py-4">Lokasi Fisik</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($rooms as $index => $room)
                                <tr class="hover:bg-gray-50/80 transition-colors duration-200">
                                    <td class="px-6 py-4 text-center text-gray-400 text-sm font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 border border-indigo-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                            </div>
                                            <div class="font-bold text-gray-900">
                                                {{ $room->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5 text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $room->location }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusConfig = [
                                                'tersedia' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500', 'label' => 'Tersedia'],
                                                'digunakan' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500', 'label' => 'Digunakan'],
                                                'perbaikan' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'dot' => 'bg-rose-500', 'label' => 'Perbaikan'],
                                            ];
                                            $curr = $statusConfig[$room->status] ?? $statusConfig['tersedia'];
                                        @endphp
                                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full {{ $curr['bg'] }} {{ $curr['text'] }} text-xs font-semibold border border-transparent">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $curr['dot'] }}"></span>
                                            {{ $curr['label'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('ruangan.show', $room->id) }}" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                                            Lihat Aset
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="mx-auto h-24 w-24 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-900">Unit ini belum memiliki ruangan</h3>
                                        <p class="text-gray-500 mt-1 mb-6 text-sm">
                                            Silakan tambahkan ruangan baru dan tetapkan Unit/Divisi ini sebagai pemiliknya.
                                        </p>
                                        <a href="{{ route('ruangan.create') }}" class="text-indigo-600 font-bold hover:underline">
                                            + Buat Ruangan Baru
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