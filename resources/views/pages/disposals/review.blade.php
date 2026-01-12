<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('disposals.index') }}" 
                   class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Review Disposal</h2>
                    <p class="text-sm text-slate-500">ID: #{{ $disposal->id }} • 
                       {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs font-medium uppercase tracking-wider rounded-full">
                    Reviewer Mode
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Warning Alert --}}
            <div class="mb-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-amber-900 mb-1">Tinjau dengan Teliti</h4>
                        <p class="text-sm text-amber-700 leading-relaxed">
                            Anda sedang meninjau pengajuan disposal dari <strong>{{ $disposal->requester->name }}</strong>. 
                            Pastikan semua informasi valid sebelum membuat keputusan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column - Information --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Asset Information Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Informasi Aset
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Asset Code --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kode Aset</label>
                                    <div class="font-mono text-xl font-bold text-red-700 tracking-tight">
                                        {{ $disposal->assetDetail->unit_code }}
                                    </div>
                                </div>
                                
                                {{-- Asset Name --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nama Aset</label>
                                    <div class="text-base font-semibold text-slate-900">
                                        {{ $disposal->assetDetail->inventory->name }}
                                    </div>
                                </div>
                                
                                {{-- Category and Model --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kategori</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->inventory->category->name }}
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Model/Tipe</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->model ?? '-' }}
                                    </div>
                                </div>
                                
                                {{-- Location and Condition --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Lokasi</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->room->name }}
                                        <span class="text-slate-400">•</span>
                                        {{ $disposal->assetDetail->room->unit->name }}
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kondisi</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->condition->label() }}
                                    </div>
                                </div>
                                
                                {{-- Purchase Date and Funding Source --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Tanggal Pembelian</label>
                                    <div class="text-sm text-slate-700">
                                        {{ \Carbon\Carbon::parse($disposal->assetDetail->purchase_date)->format('d M Y') }}
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Sumber Dana</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->fundingSource->name ?? '-' }}
                                    </div>
                                </div>
                                
                                {{-- Book Value --}}
                                <div class="md:col-span-2 space-y-2 pt-4 border-t border-slate-100">
                                    <label class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Nilai Buku</label>
                                    <div class="text-2xl font-bold text-emerald-700">
                                        Rp {{ number_format($disposal->assetDetail->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Disposal Details Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Detail Pengajuan
                            </h3>
                        </div>
                        <div class="p-6 space-y-6">
                            
                            {{-- Disposal Type --}}
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Tipe Disposal</label>
                                <div>
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium
                                        {{ $disposal->disposal_type->value == 'sell' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $disposal->disposal_type->value == 'discard' ? 'bg-slate-100 text-slate-800' : '' }}
                                        {{ $disposal->disposal_type->value == 'donation' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ $disposal->disposal_type->label() }}
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Estimated Value --}}
                            @if($disposal->estimated_value > 0)
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Estimasi Nilai Kompensasi</label>
                                    <div class="text-xl font-semibold text-slate-900">
                                        Rp {{ number_format($disposal->estimated_value, 0, ',', '.') }}
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Reason --}}
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Alasan Disposal</label>
                                <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    {{ $disposal->reason }}
                                </div>
                            </div>
                            
                            {{-- Requester Information --}}
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Diajukan Oleh</label>
                                <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg border border-slate-100">
                                    <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-medium text-sm">
                                        {{ substr($disposal->requester->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-900">{{ $disposal->requester->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $disposal->requester->email }}</p>
                                        <p class="text-xs text-slate-400 mt-1">
                                            {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Evidence Photo Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Foto Bukti Kondisi
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="relative group cursor-pointer" onclick="openLightbox()">
                                <img src="{{ Storage::url($disposal->evidence_photo) }}" 
                                     alt="Evidence Photo"
                                     class="w-full h-64 object-cover rounded-lg border border-slate-200 group-hover:opacity-90 transition-opacity duration-200">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 rounded-lg transition-all duration-200 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-white rounded-full p-3 shadow-lg">
                                        <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 text-center mt-3">Klik untuk memperbesar gambar</p>
                        </div>
                    </div>
                </div>
                
                {{-- Right Column - Review Actions --}}
                <div class="space-y-6">
                    
                    {{-- Approve Card --}}
                    <div class="bg-white rounded-xl border border-emerald-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-emerald-100 bg-emerald-50">
                            <h3 class="text-lg font-semibold text-emerald-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui Disposal
                            </h3>
                        </div>
                        <form action="{{ route('disposals.approve', $disposal) }}" method="POST" id="approveForm" class="p-6 space-y-4">
                            @csrf
                            
                            {{-- Approval Notes --}}
                            <div class="space-y-2">
                                <label for="approve_notes" class="block text-sm font-medium text-slate-700">
                                    Catatan Persetujuan
                                    <span class="text-xs font-normal text-slate-500">(opsional)</span>
                                </label>
                                <textarea id="approve_notes" name="notes" rows="3"
                                    class="w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 py-2 px-3 text-sm placeholder-slate-400"
                                    placeholder="Berikan catatan atau instruksi lanjutan..."></textarea>
                            </div>
                            
                            {{-- Realized Value --}}
                            <div class="space-y-2">
                                <label for="realized_value" class="block text-sm font-medium text-emerald-700">
                                    Nilai Realisasi Akhir
                                    <span class="text-xs font-normal text-emerald-600">(jika berbeda dari estimasi)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-slate-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" id="realized_value" name="realized_value"
                                        value="{{ old('realized_value', $disposal->estimated_value) }}"
                                        class="pl-10 w-full rounded-lg border border-emerald-300 focus:ring-emerald-500 focus:border-emerald-500 py-2 pr-3 text-sm"
                                        placeholder="0">
                                </div>
                            </div>
                            
                            {{-- Warning --}}
                            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <p class="text-xs text-amber-700 leading-relaxed">
                                        Aset akan dihapus dari sistem (soft delete) setelah disetujui. Pastikan keputusan sudah tepat.
                                    </p>
                                </div>
                            </div>
                            
                            {{-- Approve Button --}}
                            <button type="button" onclick="confirmApprove()"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-emerald-600 text-white rounded-lg font-medium hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Setujui Disposal
                            </button>
                        </form>
                    </div>
                    
                    {{-- Reject Card --}}
                    <div class="bg-white rounded-xl border border-rose-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-rose-100 bg-rose-50">
                            <h3 class="text-lg font-semibold text-rose-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Disposal
                            </h3>
                        </div>
                        <form action="{{ route('disposals.reject', $disposal) }}" method="POST" id="rejectForm" class="p-6 space-y-4">
                            @csrf
                            
                            {{-- Rejection Reason --}}
                            <div class="space-y-2">
                                <label for="rejection_reason" class="block text-sm font-medium text-slate-700">
                                    Alasan Penolakan
                                    <span class="text-xs font-normal text-slate-500">(minimal 10 karakter)</span>
                                </label>
                                <textarea id="rejection_reason" name="rejection_reason" rows="3" required minlength="10"
                                    class="w-full rounded-lg border border-slate-300 focus:ring-2 focus:ring-rose-500 focus:border-rose-500 py-2 px-3 text-sm placeholder-slate-400 @error('rejection_reason') border-rose-500 @enderror"
                                    placeholder="Jelaskan mengapa disposal ini ditolak..."></textarea>
                                @error('rejection_reason')
                                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            {{-- Reject Button --}}
                            <button type="button" onclick="confirmReject()"
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-rose-300 text-rose-700 rounded-lg font-medium hover:bg-rose-50 focus:ring-2 focus:ring-rose-500 focus:ring-offset-2 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Disposal
                            </button>
                        </form>
                    </div>
                    
                    {{-- Navigation --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 space-y-4">
                            <a href="{{ route('disposals.show', $disposal) }}"
                               class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg border border-slate-200 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Lihat Detail Lengkap
                            </a>
                            
                            <a href="{{ route('disposals.index') }}"
                               class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg border border-slate-200 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Daftar
                            </a>
                            
                            <button onclick="window.print()" 
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg border border-slate-200 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Cetak Review
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox" class="hidden fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-6" onclick="closeLightbox()">
        <div class="relative max-w-6xl w-full">
            <button onclick="closeLightbox(event)" 
                    class="absolute -top-12 right-0 text-white hover:text-slate-300 transition-colors duration-200">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img src="{{ Storage::url($disposal->evidence_photo) }}" 
                 alt="Evidence Photo"
                 class="w-full h-auto max-h-[85vh] object-contain rounded-lg">
        </div>
    </div>

    @push('scripts')
    <script>
        function openLightbox() {
            document.getElementById('lightbox').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox(event) {
            if (event) event.stopPropagation();
            document.getElementById('lightbox').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Close when clicking on backdrop
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        function confirmApprove() {
            const confirmed = confirm('Konfirmasi Persetujuan\n\nAnda akan menyetujui disposal aset ini. Aset akan dihapus dari sistem.\n\nLanjutkan?');
            if (confirmed) {
                document.getElementById('approveForm').submit();
            }
        }

        function confirmReject() {
            const reason = document.getElementById('rejection_reason').value.trim();
            if (reason.length < 10) {
                alert('Mohon isi alasan penolakan minimal 10 karakter.');
                document.getElementById('rejection_reason').focus();
                return;
            }
            
            const confirmed = confirm('Konfirmasi Penolakan\n\nAnda akan menolak pengajuan disposal ini. Aset akan tetap aktif dalam sistem.\n\nLanjutkan?');
            if (confirmed) {
                document.getElementById('rejectForm').submit();
            }
        }
    </script>
    
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .print-only {
                display: block;
            }
            body {
                background: white !important;
            }
            .bg-slate-50 {
                background: white !important;
            }
            .border {
                border-color: #e5e7eb !important;
            }
        }
    </style>
    @endpush
</x-app-layout>