<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="text-slate-500">BHP /</span>
                <span class="text-slate-500">{{ $consumable->category->name }} /</span>
                <span class="text-slate-800">Edit Barang</span>
            </div>
            <a href="{{ route('bhp.items', $consumable->category_id) }}"
                class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-slate-100 p-8">

                <div class="mb-8 border-b border-slate-100 pb-6">
                    <h3 class="text-xl font-bold text-slate-800">Edit Data Barang Habis Pakai</h3>
                    <p class="text-sm text-slate-500 mt-1">Perbarui informasi data induk barang.</p>
                </div>

                <form action="{{ route('bhp.update', $consumable->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div class="col-span-2">
                            <label class="block font-medium text-sm text-slate-700 mb-2">Nama Barang</label>
                            <input type="text" name="name" value="{{ old('name', $consumable->name) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Kertas HVS A4 80gr" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Satuan</label>
                            <input type="text" name="unit" value="{{ old('unit', $consumable->unit) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Rim / Box / Pcs" required>
                        </div>

                        <div>
                            <label class="block font-medium text-sm text-slate-700 mb-2">Tanggal Pengecekan</label>
                            <input type="date" name="check_date"
                                value="{{ old('check_date', $consumable->check_date) }}"
                                class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-medium text-sm text-slate-700 mb-2">Keterangan</label>
                        <textarea name="notes" rows="3"
                            class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-colors">{{ old('notes', $consumable->notes) }}</textarea>
                    </div>

                    <div class="flex justify-end items-center gap-4 pt-4 border-t border-slate-100">
                        <a href="{{ route('bhp.items', $consumable->category_id) }}"
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