<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <a href="{{ route('consumable.detail', $consumable->id) }}" class="p-2 rounded-lg bg-white border border-gray-200 text-gray-500 hover:text-indigo-600 hover:border-indigo-200 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Logistik Masuk</span>
                    <h2 class="text-xl font-bold text-gray-900 leading-none mt-0.5">{{ $consumable->name }}</h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. Product Summary Card --}}
            <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-lg shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div>
                            <p class="text-indigo-200 text-xs font-medium uppercase tracking-wider">Barang Habis Pakai</p>
                            <h3 class="text-2xl font-bold">{{ $consumable->name }}</h3>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-8 bg-white/10 px-6 py-3 rounded-xl backdrop-blur-sm border border-white/10">
                        <div class="text-center">
                            <p class="text-indigo-200 text-xs font-medium">Satuan</p>
                            <p class="text-lg font-bold">{{ $consumable->unit }}</p>
                        </div>
                        <div class="w-px h-8 bg-white/20"></div>
                        <div class="text-center">
                            <p class="text-indigo-200 text-xs font-medium">Total Stok</p>
                            <p class="text-lg font-bold">{{ $consumable->details->sum('current_stock') }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Decor --}}
                <div class="absolute -right-6 -bottom-10 opacity-10">
                    <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l-5.5 9h11L12 2zm0 3.84L13.93 9h-3.87L12 5.84zM17.5 13c-2.49 0-4.5 2.01-4.5 4.5s2.01 4.5 4.5 4.5 4.5-2.01 4.5-4.5-2.01-4.5-4.5-4.5zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5zM6.5 13C4.01 13 2 15.01 2 17.5S4.01 22 6.5 22s4.5-2.01 4.5-4.5S8.99 13 6.5 13zm0 7c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                </div>
            </div>

            {{-- 2. Registration Form --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-900">Form Registrasi Batch</h3>
                    <p class="text-sm text-gray-500 mt-1">Catat penerimaan stok baru ke dalam sistem.</p>
                </div>

                <form action="{{ route('consumable.storeDetail') }}" method="POST" class="p-8">
                    @csrf
                    <input type="hidden" name="consumable_id" value="{{ $consumable->id }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        {{-- Left Column: Product Details --}}
                        <div class="space-y-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2 mb-4">Detail Batch</h4>
                            
                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Merk / Vendor / Tipe</label>
                                <input type="text" name="model_name" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-300" placeholder="Cth: Sinar Dunia 80gsm" required>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-bold text-sm text-gray-700 mb-2">Jumlah Masuk <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" name="initial_stock" min="1" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all font-bold text-indigo-600 pl-4 pr-12" placeholder="0" required>
                                        <span class="absolute right-4 top-2.5 text-xs font-bold text-gray-400">{{ $consumable->unit }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block font-bold text-sm text-gray-700 mb-2">Tgl Kedatangan</label>
                                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-600" required>
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Tanggal Kadaluarsa (Exp)</label>
                                <input type="date" name="expiry_date" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-gray-600">
                                <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Kosongkan jika barang tidak memiliki masa expired (misal: ATK).
                                </p>
                            </div>
                        </div>

                        {{-- Right Column: Storage & Funding --}}
                        <div class="space-y-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2 mb-4">Penyimpanan & Dana</h4>

                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Sumber Dana</label>
                                <select name="funding_source_id" class="w-full border-gray-200 rounded-xl shadow-sm bg-gray-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer" required>
                                    <option value="">-- Pilih Sumber Dana --</option>
                                    @foreach($fundings as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }} ({{ $f->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Lokasi Simpan</label>
                                <select name="room_id" class="w-full border-gray-200 rounded-xl shadow-sm bg-gray-50 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer" required>
                                    <option value="">-- Pilih Ruangan --</option>
                                    @foreach($rooms as $r)
                                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block font-bold text-sm text-gray-700 mb-2">Catatan Tambahan</label>
                                <textarea name="notes" rows="3" class="w-full border-gray-200 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-gray-300" placeholder="Keterangan opsional..."></textarea>
                            </div>
                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-100">
                        <a href="{{ route('consumable.detail', $consumable->id) }}" class="text-gray-500 font-bold text-sm hover:text-gray-700 transition-colors">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center bg-indigo-600 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-500/30 transition-all gap-2 transform hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Stok Masuk
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>