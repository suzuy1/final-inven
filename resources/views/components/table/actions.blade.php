<div class="relative inline-block text-left">
    <details class="group">
        <summary
            class="list-none cursor-pointer px-3 py-1.5 rounded-md bg-slate-100 hover:bg-slate-200 text-xs font-bold text-slate-700 inline-flex items-center gap-1">
            Aksi
            <svg class="w-3 h-3 transition group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </summary>

        <div
            class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50 overflow-hidden text-xs text-left">
            {{ $slot }}
        </div>
    </details>
</div>
