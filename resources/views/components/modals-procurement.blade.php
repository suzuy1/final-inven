{{--
COMPONENT: MODALS PROCUREMENT
-----------------------------
Modals for Approving and Completing procurement requests.
Included in: resources/views/pages/procurements/index.blade.php
--}}

{{-- 1. APPROVE MODAL --}}
<div id="approveModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        {{-- Background overlay --}}
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closeApproveModal()"></div>

        {{-- Centering spacer --}}
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="approveForm" method="POST" onsubmit="return handleApproveSubmit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="approved">
                <input type="hidden" id="approve_id" name="procurement_id">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                            {{-- Icon Check --}}
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Setujui Pengadaan
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Konfirmasi persetujuan untuk item berikut. Tindakan ini akan mengubah status menjadi
                                    <b>Disetujui</b>.
                                </p>

                                {{-- Item Details --}}
                                <div class="mt-4 bg-gray-50 p-3 rounded-lg border border-gray-100 text-sm">
                                    <div class="grid grid-cols-3 gap-y-2">
                                        <div class="text-gray-500">Barang:</div>
                                        <div class="col-span-2 font-medium text-gray-900" id="modal_item_name">-</div>

                                        <div class="text-gray-500">Jumlah:</div>
                                        <div class="col-span-2 font-medium text-gray-900"><span
                                                id="modal_item_qty">0</span> Unit</div>

                                        <div class="text-gray-500">Tipe:</div>
                                        <div class="col-span-2 font-medium text-gray-900" id="modal_item_type">-</div>

                                        <div class="text-gray-500">Kategori:</div>
                                        <div class="col-span-2 font-medium text-gray-900" id="modal_item_category">-
                                        </div>
                                    </div>
                                </div>

                                {{-- Admin Note Input --}}
                                <div class="mt-4">
                                    <label for="approve_admin_note"
                                        class="block text-xs font-medium text-gray-700 mb-1">Catatan Persetujuan
                                        (Opsional)</label>
                                    <textarea name="admin_note" id="approve_admin_note" rows="2"
                                        class="shadow-sm focus:ring-emerald-500 focus:border-emerald-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Tambahkan arahan untuk pembelian..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer Buttons --}}
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Setujui Usulan
                    </button>
                    <button type="button" onclick="closeApproveModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 2. COMPLETE MODAL --}}
<div id="completeModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            onclick="closeCompleteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
            <form id="completeForm" method="POST" onsubmit="return handleCompleteSubmit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="completed">
                <input type="hidden" id="complete_id" name="procurement_id">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Selesaikan
                                Pengadaan & Input Stok</h3>

                            {{-- Info Box --}}
                            <div class="mt-4 bg-indigo-50 p-3 rounded-md border border-indigo-100 text-sm mb-4">
                                <div class="flex justify-between items-start">
                                    <div class="font-medium text-indigo-800" id="modal_complete_item_name">Nama Barang
                                    </div>
                                    <div
                                        class="bg-white px-2 py-0.5 rounded text-indigo-600 text-xs font-bold border border-indigo-200">
                                        <span id="modal_complete_item_qty">0</span> Unit
                                    </div>
                                </div>
                                <div class="flex gap-3 text-xs text-indigo-600 mt-1">
                                    <span id="modal_complete_item_type">Type</span> &bull; <span
                                        id="modal_complete_item_category">Category</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-2">
                                {{-- Target Inventory --}}
                                <div class="col-span-2">
                                    <label for="consumable_id" class="block text-sm font-medium text-gray-700">Masuk ke
                                        Inventaris (Master Data)</label>
                                    <select name="consumable_id" id="consumable_id"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">-- Pilih Barang (Opsional / Jika Ada) --</option>
                                        @if(isset($consumables))
                                            @foreach($consumables as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} (Stok:
                                                    {{ $item->details_sum_current_stock ?? 0 }})</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="mt-1 text-xs text-gray-500">Jika dipilih, stok akan otomatis bertambah.
                                    </p>
                                </div>

                                {{-- Batch Code --}}
                                <div>
                                    <label for="batch_code" class="block text-sm font-medium text-gray-700">Kode
                                        Batch</label>
                                    <input type="text" name="batch_code" id="batch_code"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>

                                {{-- Real Unit Price --}}
                                <div>
                                    <label for="unit_price" class="block text-sm font-medium text-gray-700">Harga Satuan
                                        Real</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="unit_price" id="unit_price" min="0"
                                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                {{-- Notes --}}
                                <div class="col-span-2">
                                    <label for="complete_admin_note"
                                        class="block text-sm font-medium text-gray-700">Catatan Akhir</label>
                                    <textarea name="admin_note" id="complete_admin_note" rows="2"
                                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                        placeholder="Catatan penerimaan barang..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Selesaikan
                    </button>
                    <button type="button" onclick="closeCompleteModal()"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 3. JAVASCRIPT HANDLERS (Dynamic Action URL) --}}
<script>
    function handleApproveSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('approve_id').value;
        const form = document.getElementById('approveForm');
        form.action = `/pengadaan/${id}/status`;
        form.submit();
    }

    function handleCompleteSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('complete_id').value;
        const form = document.getElementById('completeForm');
        const stockItem = document.getElementById('consumable_id').value;

        // Validation warning
        if (stockItem === "") {
            const proceed = confirm("PERHATIAN: Anda tidak memilih Barang Inventaris.\n\nStok TIDAK akan bertambah, pengadaan hanya akan ditandai sebagai 'Selesai'.\n\nLanjutkan?");
            if (!proceed) return false;
        }

        form.action = `/pengadaan/${id}/status`;
        form.submit();
    }
</script>