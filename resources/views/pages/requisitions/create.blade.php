<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('permintaan.index') }}" class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h2 class="font-bold text-xl text-gray-900 leading-tight">
                    Buat Permintaan Baru
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('permintaan.store') }}" method="POST">
                @csrf
                <div class="space-y-6">

                    {{-- 1. Identitas Pengusul (Read Only) --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="w-full">
                                <h3 class="text-lg font-bold text-gray-900">Identitas Pengusul</h3>
                                <p class="text-sm text-gray-500 mb-4">Data otomatis diambil dari akun Anda.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama
                                            Lengkap</label>
                                        <input type="text" name="requestor_name" value="{{ Auth::user()->name }}"
                                            readonly
                                            class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm text-gray-600 font-medium cursor-not-allowed focus:ring-0">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Unit Kerja /
                                            Divisi</label>
                                        <input type="text"
                                            value="{{ Auth::user()->role == 'admin' ? 'Administrator' : 'Staff Umum' }}"
                                            readonly
                                            class="w-full bg-gray-50 border-gray-200 rounded-lg text-sm text-gray-600 font-medium cursor-not-allowed focus:ring-0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Detail Barang --}}
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                        <div class="flex items-start gap-4">
                            <div
                                class="h-10 w-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="w-full">
                                <h3 class="text-lg font-bold text-gray-900">Detail Barang</h3>
                                <p class="text-sm text-gray-500 mb-6">Pilih jenis dan spesifikasi barang yang
                                    dibutuhkan.</p>

                                {{-- Radio Cards for Type Selection --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6" x-data="{ type: 'asset' }">
                                    {{-- Hidden Input for x-model sync if needed, but radios handle it --}}

                                    <label class="cursor-pointer" @click="type = 'asset'">
                                        <input type="radio" name="type" value="asset" class="peer sr-only"
                                            x-model="type">
                                        <div
                                            class="p-4 rounded-xl border-2 border-gray-200 hover:border-indigo-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all group">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="font-bold text-gray-700 peer-checked:text-indigo-700">Aset
                                                    Tetap</span>
                                                <svg class="w-5 h-5 text-gray-400 peer-checked:text-indigo-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-xs text-gray-500">Barang inventaris jangka panjang (Laptop,
                                                Meja, AC).
                                            </p>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer" @click="type = 'consumable'">
                                        <input type="radio" name="type" value="consumable" class="peer sr-only"
                                            x-model="type">
                                        <div
                                            class="p-4 rounded-xl border-2 border-gray-200 hover:border-indigo-200 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all group">
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="font-bold text-gray-700 peer-checked:text-indigo-700">Barang
                                                    Habis
                                                    Pakai</span>
                                                <svg class="w-5 h-5 text-gray-400 peer-checked:text-indigo-600 opacity-0 peer-checked:opacity-100 transition-opacity"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <p class="text-xs text-gray-500">Barang operasional harian (Kertas, Tinta,
                                                ATK).</p>
                                        </div>
                                    </label>

                                    {{-- CATEGORY DROPDOWN (FULL WIDTH BELOW RADIOS) --}}
                                    <div class="col-span-1 sm:col-span-2 mt-2">
                                        <label class="block font-bold text-sm text-gray-700 mb-2">Kategori Barang <span
                                                class="text-rose-500">*</span></label>

                                        {{-- Asset Categories --}}
                                        <div x-show="type === 'asset'">
                                            <select name="category_id" :disabled="type !== 'asset'"
                                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                required>
                                                <option value="" disabled selected>-- Pilih Kategori Aset --</option>
                                                @foreach($assetCategories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Consumable Categories --}}
                                        <div x-show="type === 'consumable'" style="display: none;">
                                            <select name="category_id" :disabled="type !== 'consumable'"
                                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                required>
                                                <option value="" disabled selected>-- Pilih Kategori BHP --</option>
                                                @foreach($consumableCategories as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block font-bold text-sm text-gray-700 mb-2">Nama Barang <span
                                                class="text-rose-500">*</span></label>
                                        <input type="text" name="item_name"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="Contoh: MacBook Pro M2, Kertas A4 PaperOne" required>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block font-bold text-sm text-gray-700 mb-2">Jumlah (Qty) <span
                                                    class="text-rose-500">*</span></label>
                                            <input type="number" name="quantity" min="1" value="1"
                                                class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all text-center font-bold"
                                                required>
                                        </div>
                                        <div>
                                            <label class="block font-bold text-sm text-gray-700 mb-2">Est. Harga Satuan
                                                (Opsional)</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 font-bold text-sm">Rp</span>
                                                <input type="number" name="unit_price_estimation" min="0"
                                                    class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                                    placeholder="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block font-bold text-sm text-gray-700 mb-2">Alasan & Spesifikasi
                                            <span class="text-rose-500">*</span></label>
                                        <textarea name="description" rows="3"
                                            class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                            placeholder="Jelaskan kenapa barang ini dibutuhkan dan spesifikasi detailnya..."
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Action Buttons --}}
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('permintaan.index') }}"
                            class="text-gray-500 font-bold text-sm hover:text-gray-700 transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            Kirim Permintaan Barang
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
