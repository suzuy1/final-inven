<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $detail->consumable->name }} /</span>
                <span class="text-slate-500">{{ $detail->batch_code }} /</span>
                <span class="text-slate-800">Edit Stok</span>
            </div>
            <a href="{{ route('consumable.detail', $detail->consumable_id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Edit Data Batch Stok</h3>
                    <p class="text-sm text-slate-500 mt-1">Perbarui informasi batch stok masuk.</p>
                </div>

                <form action="{{ route('consumable.updateBatch', $detail->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        {{-- Merek / Tipe --}}
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-slate-700 mb-2">Merek / Tipe</label>
                            <input type="text" name="model_name" value="{{ old('model_name', $detail->model_name) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                        </div>

                        {{-- Tgl Masuk --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Tanggal Pembelian/Masuk</label>
                            <input type="date" name="purchase_date"
                                value="{{ old('purchase_date', $detail->purchase_date) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                        </div>

                        {{-- Tgl Kadaluarsa --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Tanggal Kadaluwarsa</label>
                            <input type="date" name="expiry_date" value="{{ old('expiry_date', $detail->expiry_date) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            <span class="text-xs text-slate-400">Kosongkan jika tidak ada</span>
                        </div>

                        {{-- Lokasi --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Lokasi Penyimpanan</label>
                            <select name="room_id"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ $detail->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sumber Dana --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Sumber Pendanaan</label>
                            <select name="funding_source_id"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                required>
                                @foreach($fundings as $funding)
                                    <option value="{{ $funding->id }}" {{ $detail->funding_source_id == $funding->id ? 'selected' : '' }}>
                                        {{ $funding->name }} ({{ $funding->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Kondisi --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Kondisi Saat Ini</label>
                            <select name="condition"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <option value="baik" {{ $detail->condition == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak" {{ $detail->condition == 'rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="kadaluarsa" {{ $detail->condition == 'kadaluarsa' ? 'selected' : '' }}>
                                    Kadaluarsa (Expired)</option>
                            </select>
                        </div>

                        {{-- Stok (Read Only / Limited Edit) --}}
                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Stok Saat Ini (Koreksi)</label>
                            <input type="number" name="current_stock"
                                value="{{ old('current_stock', $detail->current_stock) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                min="0">
                            <span class="text-xs text-rose-500">* Ubah hanya jika ada selisih stok fisik
                                (opname).</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Keterangan / Catatan</label>
                        <textarea name="notes" rows="3"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('notes', $detail->notes) }}</textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('consumable.detail', $detail->consumable_id) }}"
                            class="text-slate-600 hover:text-slate-800 text-sm font-medium transition-colors">Batal</a>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>