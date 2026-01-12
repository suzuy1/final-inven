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
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Detail Disposal</h2>
                    <p class="text-sm text-slate-500">ID: #{{ $disposal->id }} • 
                       {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}</p>
                </div>
            </div>
            
            {{-- Status Badge --}}
            <div class="flex items-center gap-3">
                @if($disposal->status->value == 'pending')
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 text-amber-800 rounded-lg border border-amber-200 text-sm font-medium">
                        <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                        Menunggu Review
                    </span>
                @elseif($disposal->status->value == 'approved')
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-800 rounded-lg border border-emerald-200 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Disetujui
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-rose-50 text-rose-800 rounded-lg border border-rose-200 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Ditolak
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Main Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column - Main Information --}}
                <div class="lg:col-span-2 space-y-8">
                    
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
                                    <div class="font-mono text-2xl font-bold text-red-700 tracking-tight">
                                        {{ $disposal->assetDetail->unit_code }}
                                    </div>
                                </div>
                                
                                {{-- Asset Name --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Nama Aset</label>
                                    <div class="text-lg font-semibold text-slate-900">
                                        {{ $disposal->assetDetail->inventory->name }}
                                    </div>
                                </div>
                                
                                {{-- Category and Condition --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kategori</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->inventory->category->name }}
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Kondisi</label>
                                    <div class="text-sm text-slate-700">
                                        {{ $disposal->assetDetail->condition->label() }}
                                    </div>
                                </div>
                                
                                {{-- Location --}}
                                <div class="md:col-span-2 space-y-2">
                                    <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Lokasi</label>
                                    <div class="flex items-center gap-2 text-sm text-slate-700">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $disposal->assetDetail->room->name }} - {{ $disposal->assetDetail->room->unit->name }}
                                    </div>
                                </div>
                                
                                {{-- Book Value --}}
                                <div class="md:col-span-2 space-y-2 pt-4 border-t border-slate-100">
                                    <label class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Nilai Buku</label>
                                    <div class="text-2xl font-bold text-emerald-700">
                                        Rp {{ number_format($disposal->book_value ?? $disposal->assetDetail->price, 0, ',', '.') }}
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
                                Detail Disposal
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
                            
                            {{-- Reason --}}
                            <div class="space-y-2">
                                <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Alasan Disposal</label>
                                <div class="text-sm text-slate-700 leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-100">
                                    {{ $disposal->reason }}
                                </div>
                            </div>
                            
                            {{-- Financial Values --}}
                            @if($disposal->estimated_value > 0 || $disposal->realized_value > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                                    @if($disposal->estimated_value > 0)
                                        <div class="space-y-2">
                                            <label class="text-xs font-medium text-slate-500 uppercase tracking-wide">Estimasi Nilai</label>
                                            <div class="text-xl font-semibold text-slate-900">
                                                Rp {{ number_format($disposal->estimated_value, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($disposal->status->value == 'approved' && $disposal->realized_value > 0)
                                        <div class="space-y-2">
                                            <label class="text-xs font-medium text-emerald-600 uppercase tracking-wide">Realisasi Akhir</label>
                                            <div class="text-xl font-semibold text-emerald-700">
                                                Rp {{ number_format($disposal->realized_value, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                            
                            {{-- Admin Notes --}}
                            @if($disposal->notes)
                                <div class="space-y-2 pt-4 border-t border-slate-100">
                                    <label class="text-xs font-medium text-amber-600 uppercase tracking-wide flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Catatan Admin
                                    </label>
                                    <div class="text-sm text-amber-800 leading-relaxed bg-amber-50 p-4 rounded-lg border border-amber-100">
                                        {{ $disposal->notes }}
                                    </div>
                                </div>
                            @endif
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
                
                {{-- Right Column - Timeline & Actions --}}
                <div class="space-y-8">
                    
                    {{-- Timeline Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                            <h3 class="text-lg font-semibold text-slate-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Timeline
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6">
                                
                                {{-- Request Timeline --}}
                                <div class="relative">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </div>
                                            <div class="h-full w-px bg-slate-200 absolute left-5 top-10 bottom-0"></div>
                                        </div>
                                        <div class="flex-1 pt-1">
                                            <h4 class="font-medium text-slate-900">Diajukan</h4>
                                            <p class="text-sm text-slate-500 mt-1">
                                                {{ \Carbon\Carbon::parse($disposal->created_at)->format('d M Y, H:i') }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-3">
                                                <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-700 font-medium text-sm">
                                                    {{ substr($disposal->requester->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-slate-900">{{ $disposal->requester->name }}</p>
                                                    <p class="text-xs text-slate-500">{{ $disposal->requester->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- Review Timeline --}}
                                @if($disposal->status->value != 'pending')
                                    <div class="relative">
                                        <div class="flex items-start gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-10 h-10 {{ $disposal->status->value == 'approved' ? 'bg-emerald-100' : 'bg-rose-100' }} rounded-full flex items-center justify-center">
                                                    @if($disposal->status->value == 'approved')
                                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex-1 pt-1">
                                                <h4 class="font-medium {{ $disposal->status->value == 'approved' ? 'text-emerald-900' : 'text-rose-900' }}">
                                                    {{ $disposal->status->value == 'approved' ? 'Disetujui' : 'Ditolak' }}
                                                </h4>
                                                <p class="text-sm text-slate-500 mt-1">
                                                    {{ \Carbon\Carbon::parse($disposal->approved_at)->format('d M Y, H:i') }}
                                                </p>
                                                @if($disposal->reviewer)
                                                    <div class="flex items-center gap-3 mt-3">
                                                        <div class="w-8 h-8 {{ $disposal->status->value == 'approved' ? 'bg-emerald-100' : 'bg-rose-100' }} rounded-full flex items-center justify-center {{ $disposal->status->value == 'approved' ? 'text-emerald-700' : 'text-rose-700' }} font-medium text-sm">
                                                            {{ substr($disposal->reviewer->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-slate-900">{{ $disposal->reviewer->name }}</p>
                                                            <p class="text-xs text-slate-500">{{ $disposal->reviewer->email }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Action Card --}}
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-6 space-y-4">
                            
                            @if(auth()->user()->role === 'admin' && $disposal->status->value == 'pending')
                                @if(auth()->id() === $disposal->requested_by)
                                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-amber-800">Review Independen Diperlukan</p>
                                                <p class="text-xs text-amber-600 mt-1">Pengajuan ini harus di-review oleh admin lain untuk menjaga integritas data.</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('disposals.review', $disposal) }}" 
                                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors duration-200 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Review Disposal
                                    </a>
                                @endif
                            @endif
                            
                            {{-- Back Button --}}
                            <a href="{{ route('disposals.index') }}" 
                               class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border border-slate-300 text-slate-700 rounded-lg font-medium hover:bg-slate-50 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Kembali ke Daftar
                            </a>
                            
                            {{-- Additional Actions --}}
                            @if(auth()->user()->role === 'admin')
                                <div class="pt-4 border-t border-slate-100">
                                    <h4 class="text-sm font-medium text-slate-700 mb-3">Lainnya</h4>
                                    <div class="space-y-2">
                                        <button onclick="window.print()" 
                                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg border border-slate-200 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Cetak Laporan
                                        </button>
                                        <button onclick="downloadPDF()" 
                                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 rounded-lg border border-slate-200 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download PDF
                                        </button>
                                    </div>
                                </div>
                            @endif
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

        function downloadPDF() {
            // Implement PDF download functionality
            alert('Fitur download PDF akan diimplementasikan');
        }
    </script>
    
    <style>
        .print-only {
            display: none;
        }
        
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
        }
    </style>
    @endpush
</x-app-layout>