<aside id="logo-sidebar"
   class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col shadow-2xl"
   aria-label="Sidebar">

   <!-- Brand Section -->
   <div class="shrink-0 h-16 flex items-center px-6 bg-slate-900 border-b border-slate-800/50">
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
         <div
            class="relative flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-lg shadow-indigo-500/30 transition-all duration-300 group-hover:scale-110 group-hover:rotate-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <path
                  d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
               </path>
               <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
               <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
         </div>
         <div class="flex flex-col">
            <span
               class="text-lg font-bold text-white tracking-tight leading-none group-hover:text-indigo-400 transition-colors">INVENTARIS</span>
            <span class="text-[10px] font-medium text-slate-500 uppercase tracking-widest">System Pro</span>
         </div>
      </a>
   </div>

   <!-- Navigation -->
   <div class="flex-1 px-4 py-6 overflow-y-auto custom-scrollbar space-y-1">

      <!-- Dashboard -->
      <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7"></rect>
            <rect x="14" y="3" width="7" height="7"></rect>
            <rect x="14" y="14" width="7" height="7"></rect>
            <rect x="3" y="14" width="7" height="7"></rect>
         </svg>
         <span class="text-sm font-medium">Dashboard</span>
      </x-nav-link>

      <!-- Section: Aset -->
      <div class="mt-6 mb-2 px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Manajemen Aset</div>

      <x-nav-link :href="route('inventaris.categories')" :active="request()->routeIs('inventaris*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('inventaris*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('inventaris*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
               d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
            </path>
            <polyline points="7.5 4.21 12 6.81 16.5 4.21"></polyline>
            <polyline points="7.5 19.79 7.5 14.6 3 12"></polyline>
            <polyline points="21 12 16.5 14.6 16.5 19.79"></polyline>
            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
            <line x1="12" y1="22.08" x2="12" y2="12"></line>
         </svg>
         <span class="text-sm font-medium">Inventaris Aset</span>
      </x-nav-link>

      <x-nav-link :href="route('bhp.categories')" :active="request()->routeIs('bhp*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('bhp*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('bhp*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
               d="M20.9 19.9l-1.3-9.5c-.1-.9-.9-1.5-1.7-1.4l-11.5 2c-.9.2-1.5 1-1.4 1.9l1.3 9.5c.2.9 1 1.5 1.9 1.4l11.5-2c.9-.2 1.5-1 1.3-1.9z">
            </path>
            <path d="M3.9 8.1L5.2 16"></path>
            <path d="M7 6l1.3 7.9"></path>
            <path d="M12.9 5l1.3 7.9"></path>
            <path d="M15.8 4.5l1.3 7.9"></path>
            <path d="M18.9 4l-1.5 9"></path>
         </svg>
         <span class="text-sm font-medium">Barang Habis Pakai</span>
      </x-nav-link>

      <!-- Section: Sirkulasi -->
      <div class="mt-6 mb-2 px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sirkulasi & Transaksi
      </div>

      <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('peminjaman*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('peminjaman*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="16" y1="13" x2="8" y2="13"></line>
            <line x1="16" y1="17" x2="8" y2="17"></line>
            <polyline points="10 9 9 9 8 9"></polyline>
         </svg>
         <span class="text-sm font-medium">Peminjaman</span>
      </x-nav-link>

      <x-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('transaksi*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('transaksi*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
         </svg>
         <span class="text-sm font-medium">Transaksi BHP</span>
      </x-nav-link>

      <x-nav-link :href="route('mutasi.index')" :active="request()->routeIs('mutasi*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('mutasi*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('mutasi*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="17 1 21 5 17 9"></polyline>
            <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
            <polyline points="7 23 3 19 7 15"></polyline>
            <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
         </svg>
         <span class="text-sm font-medium">Mutasi</span>
      </x-nav-link>

      <x-nav-link :href="route('disposals.index')" :active="request()->routeIs('disposals*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('disposals*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <div class="relative">
            <svg
               class="w-5 h-5 transition-colors {{ request()->routeIs('disposals*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
               xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
               <polyline points="3 6 5 6 21 6"></polyline>
               <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
               <line x1="10" y1="11" x2="10" y2="17"></line>
               <line x1="14" y1="11" x2="14" y2="17"></line>
            </svg>
            <!-- Notification Badge -->
            @if(auth()->user()->role === 'admin')
               @php $pendingDisposals = \App\Models\Disposal::where('status', 'pending')->count(); @endphp
               @if($pendingDisposals > 0)
                  <span class="absolute -top-1.5 -right-1.5 flex h-3 w-3">
                     <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                     <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                  </span>
               @endif
            @endif
         </div>
         <span class="text-sm font-medium">Pembuangan</span>
      </x-nav-link>

      <x-nav-link :href="route('pengadaan.index')" :active="request()->routeIs('pengadaan*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('pengadaan*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('pengadaan*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <path d="M16 10a4 4 0 0 1-8 0"></path>
         </svg>
         <span class="text-sm font-medium">Pengadaan</span>
      </x-nav-link>

      <!-- Section: Data Master -->
      <div class="mt-6 mb-2 px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">Data Master</div>

      <x-nav-link :href="route('ruangan.index')" :active="request()->routeIs('ruangan*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('ruangan*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('ruangan*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
         </svg>
         <span class="text-sm font-medium">Ruangan</span>
      </x-nav-link>

      <x-nav-link :href="route('unit.index')" :active="request()->routeIs('unit*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('unit*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('unit*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
         </svg>
         <span class="text-sm font-medium">Unit / Divisi</span>
      </x-nav-link>

      <x-nav-link :href="route('sumber-dana.index')" :active="request()->routeIs('sumber-dana*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('sumber-dana*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('sumber-dana*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="1" x2="12" y2="23"></line>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
         </svg>
         <span class="text-sm font-medium">Sumber Dana</span>
      </x-nav-link>

      <!-- Section: System -->
      <div class="mt-6 mb-2 px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">System</div>

      <x-nav-link :href="route('users.index')" :active="request()->routeIs('users*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('users*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('users*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
            <circle cx="8.5" cy="7" r="4"></circle>
            <line x1="20" y1="8" x2="20" y2="14"></line>
            <line x1="23" y1="11" x2="17" y2="11"></line>
         </svg>
         <span class="text-sm font-medium">Users</span>
      </x-nav-link>

      <x-nav-link :href="route('report.index')" :active="request()->routeIs('report*')"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('report*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
         <svg
            class="w-5 h-5 transition-colors {{ request()->routeIs('report*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
            <polyline points="13 2 13 9 20 9"></polyline>
         </svg>
         <span class="text-sm font-medium">Laporan</span>
      </x-nav-link>

   </div>

   <!-- User Profile & Logout (Footer) -->
   <div class="shrink-0 p-4 bg-slate-900 border-t border-slate-800">
      <form method="POST" action="{{ route('logout') }}">
         @csrf
         <button type="submit"
            class="w-full group flex items-center gap-3 px-3 py-3 rounded-xl transition-all duration-200 hover:bg-rose-500/10 border border-transparent hover:border-rose-500/20">
            <div class="relative">
               <div
                  class="h-9 w-9 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                     <polyline points="16 17 21 12 16 7"></polyline>
                     <line x1="21" y1="12" x2="9" y2="12"></line>
                  </svg>
               </div>
            </div>
            <div class="text-left">
               <p class="text-xs font-semibold text-rose-400 group-hover:text-rose-500">Sign Out</p>
               <p class="text-[10px] text-slate-500">{{ Auth::user()->name ?? 'User' }}</p>
            </div>
         </button>
      </form>
   </div>
</aside>