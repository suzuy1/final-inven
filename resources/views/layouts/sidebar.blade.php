<aside
   class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col"
   aria-label="Sidebar">

   <div class="shrink-0 px-6 py-6 bg-slate-900 z-10">
      <div class="flex items-center gap-3">
         <div class="relative flex items-center justify-center">
            <div class="absolute inset-0 bg-indigo-500/30 blur-md rounded-full"></div>
            <svg class="relative w-10 h-10 transform transition-transform hover:scale-110 duration-300"
               viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
               <!-- Left Face: Darkest -->
               <path d="M16 28L6 22.2V10.2L16 16V28Z" fill="#4338ca" />
               <!-- Right Face: Medium -->
               <path d="M16 28L26 22.2V10.2L16 16V28Z" fill="#4f46e5" />
               <!-- Top Face: Lightest -->
               <path d="M16 16L26 10.2L16 4L6 10.2L16 16Z" fill="#6366f1" />
               <!-- Gloss effect -->
               <path d="M16 4L6 10.2L16 16L26 10.2L16 4Z" fill="url(#gloss_gradient)" opacity="0.4" />
               <defs>
                  <linearGradient id="gloss_gradient" x1="6" y1="10" x2="26" y2="10" gradientUnits="userSpaceOnUse">
                     <stop stop-color="white" stop-opacity="0.5" />
                     <stop offset="1" stop-color="white" stop-opacity="0" />
                  </linearGradient>
               </defs>
            </svg>
         </div>
         <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-tight">SIM INVENTARIS</span>
      </div>
   </div>

   <div class="flex-1 px-3 pb-4 overflow-y-auto custom-scrollbar">
      <ul class="space-y-1 font-medium">
         <li>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13 9V3H21V9H13ZM13 21V11H21V21H13ZM3 21V15H11V21H3ZM3 13V3H11V13H3Z" />
               </svg>
               <span class="ms-3">Dashboard</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Aset & Barang</div>

         <li>
            <x-nav-link :href="route('inventaris.categories')" :active="request()->routeIs('inventaris*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('inventaris*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('inventaris*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M12.6,2L20,6.2C20.6,6.5 21,7.2 21,8V16.4C21,17.2 20.6,17.9 20,18.2L12.6,22.4C12.4,22.5 12.2,22.5 12,22.5C11.8,22.5 11.6,22.5 11.4,22.3L4,18.1C3.4,17.8 3,17.1 3,16.4V8C3,7.2 3.4,6.5 4,6.2L11.4,2C11.6,1.9 11.8,1.9 12,1.9C12.2,1.9 12.4,1.9 12.6,2Z" />
               </svg>
               <span class="ms-3">Inventaris (Aset)</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('bhp.categories')" :active="request()->routeIs('bhp*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('bhp*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('bhp*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M20,6H16V5C16,3.9 15.1,3 14,3H10C8.9,3 8,3.9 8,5V6H4C2.9,6 2,6.9 2,8V19C2,20.1 2.9,21 4,21H20C21.1,21 22,20.1 22,19V8C22,6.9 21.1,6 20,6ZM10,5H14V6H10V5ZM20,19H4V8H20V19ZM12,9C10.3,9 9,10.3 9,12C9,13.7 10.3,15 12,15C13.7,15 15,13.7 15,12C15,10.3 13.7,9 12,9Z" />
               </svg>
               <span class="ms-3">Barang Habis Pakai</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Akuisisi</div>

         <li>
            <x-nav-link :href="route('permintaan.index')" :active="request()->routeIs('permintaan*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('permintaan*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('permintaan*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M19,3H5C3.9,3 3,3.9 3,5V19C3,20.1 3.9,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.9 20.1,3 19,3ZM15,12H13V16H11V12H9L12,9L15,12Z" />
               </svg>
               <span class="ms-3">Permintaan Barang</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('pengadaan.index')" :active="request()->routeIs('pengadaan*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('pengadaan*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('pengadaan*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M19,3H5C3.9,3 3,3.9 3,5V19C3,20.1 3.9,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.9 20.1,3 19,3ZM13,17H11V13H7V11H11V7H13V11H17V13H13V17Z" />
               </svg>
               <span class="ms-3">Usulan Pengadaan</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Data Master</div>

         <li>
            <x-nav-link :href="route('ruangan.index')" :active="request()->routeIs('ruangan*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('ruangan*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('ruangan*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M19,3H5C3.9,3 3,3.9 3,5V19C3,20.1 3.9,21 5,21H19C20.1,21 21,20.1 21,19V5C21,3.9 20.1,3 19,3ZM10,17H6V7H10V17ZM18,17H14V7H18V17Z" />
               </svg>
               <span class="ms-3">Ruangan</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('unit.index')" :active="request()->routeIs('unit*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('unit*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('unit*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
               </svg>
               <span class="ms-3">Unit / Divisi</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('sumber-dana.index')" :active="request()->routeIs('sumber-dana*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('sumber-dana*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('sumber-dana*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M12.5 6.25C12.5 4.87 11.38 3.75 10 3.75H5C3.62 3.75 2.5 4.87 2.5 6.25V7.5H12.5V6.25ZM13.75 3.75H21.25V6.25H13.75V3.75ZM2.5 8.75V18.75C2.5 19.44 3.06 20 3.75 20H20C20.69 20 21.25 19.44 21.25 18.75V8.75H2.5ZM12.5 15C12.5 16.38 11.38 17.5 10 17.5H5C3.62 17.5 2.5 16.38 2.5 15V13.75H12.5V15Z" />
               </svg>
               <span class="ms-3">Sumber Dana</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Sirkulasi</div>

         <li>
            <x-nav-link :href="route('transaksi.index')" :active="request()->routeIs('transaksi*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('transaksi*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('transaksi*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M16 10V7H8V10H6V7C6 5.9 6.9 5 8 5H16C17.1 5 18 5.9 18 7V10H16ZM16 14V17H8V14H6V17C6 18.1 6.9 19 8 19H16C17.1 19 18 18.1 18 17V14H16Z" />
                  <path d="M4 11H20V13H4V11Z" />
               </svg>
               <span class="ms-3">Transaksi BHP</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('peminjaman.index')" :active="request()->routeIs('peminjaman*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('peminjaman*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('peminjaman*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-1V1h-2zm3 18H5V8h14v11z" />
               </svg>
               <span class="ms-3">Peminjaman Aset</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('mutasi.index')" :active="request()->routeIs('mutasi*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('mutasi*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('mutasi*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M12 2H4C2.9 2 2 2.9 2 4V16H4V4H12V2ZM12 6H8C6.9 6 6 6.9 6 8V18C6 19.1 6.9 20 8 20H20C21.1 20 22 19.1 22 18V13L17 7.5L12 13V6ZM16 13H11V11H16V13Z" />
                  <path d="M8 8H20V18H8V8Z" opacity="0.3" />
               </svg>
               <span class="ms-3">Mutasi Aset</span>
            </x-nav-link>
         </li>

         <li>
            <x-nav-link :href="route('disposals.index')" :active="request()->routeIs('disposals*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('disposals*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('disposals*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z" />
               </svg>
               <span class="ms-3">Disposal Aset</span>
               @if(auth()->user()->role === 'admin')
                  @php
                     $pendingDisposals = \App\Models\Disposal::where('status', 'pending')->count();
                  @endphp
                  @if($pendingDisposals > 0)
                     <span
                        class="inline-flex items-center justify-center w-5 h-5 ms-auto text-xs font-bold text-white bg-red-500 rounded-full">
                        {{ $pendingDisposals }}
                     </span>
                  @endif
               @endif
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengaturan</div>

         <li>
            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('users*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('users*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
               </svg>
               <span class="ms-3">Manajemen Pengguna</span>
            </x-nav-link>
         </li>

         <div class="pt-6 pb-2 px-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Laporan</div>

         <li>
            <x-nav-link :href="route('report.index')" :active="request()->routeIs('report*')"
               class="flex items-center p-2 rounded-lg group {{ request()->routeIs('report*') ? 'bg-indigo-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
               <svg
                  class="w-5 h-5 transition duration-75 {{ request()->routeIs('report*') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}"
                  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                  <path
                     d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" />
               </svg>
               <span class="ms-3">Pusat Laporan</span>
            </x-nav-link>
         </li>

         <li class="mt-8 pt-4 border-t border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
               @csrf
               <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                  class="flex items-center p-2 text-rose-400 rounded-lg hover:bg-rose-900/20 group cursor-pointer transition-colors">
                  <svg class="w-5 h-5 text-rose-500 transition duration-75 group-hover:text-rose-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                     <path
                        d="M13 3h-2v10h2V3zm4.83 2.17l-1.42 1.42C17.99 7.86 19 9.81 19 12c0 3.87-3.13 7-7 7s-7-3.13-7-7c0-2.19 1.01-4.14 2.58-5.42L6.17 5.17C4.23 6.82 3 9.26 3 12c0 4.97 4.03 9 9 9s9-4.03 9-9c0-2.74-1.23-5.18-3.17-6.83z" />
                  </svg>
                  <span class="ms-3">Logout</span>
               </a>
            </form>
         </li>
      </ul>
   </div>
</aside>