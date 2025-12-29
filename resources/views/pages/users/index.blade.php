<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <span class="text-slate-500">Manajemen Pengguna /</span>
            <span class="text-slate-800">Daftar User</span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-slate-800">Daftar Pengguna Sistem</h3>
                    <p class="text-slate-500 mt-1">Kelola akun pengguna dan hak akses aplikasi.</p>
                </div>
                <a href="{{ route('users.create') }}"
                    class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    Tambah User
                </a>
            </div>

            <div class="bg-white shadow-sm rounded-xl border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="bg-slate-50 text-xs uppercase text-slate-700 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Lengkap</th>
                                <th class="px-6 py-4 font-bold">Email</th>
                                <th class="px-6 py-4 font-bold">Role (Hak Akses)</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($users as $user)
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                                {{ substr($user->name, 0, 2) }}
                                            </div>
                                            <span class="font-bold text-slate-800">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if($user->role == 'admin')
                                            <span
                                                class="bg-indigo-100 text-indigo-800 text-xs font-bold px-2.5 py-1 rounded-full border border-indigo-200">Administrator</span>
                                        @else
                                            <span
                                                class="bg-slate-100 text-slate-600 text-xs font-bold px-2.5 py-1 rounded-full border border-slate-200">User
                                                Biasa</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <x-table.actions>
                                            {{-- EDIT --}}
                                            <x-table.action-link href="{{ route('users.edit', $user->id) }}">
                                                ✏️ Edit Profil
                                            </x-table.action-link>

                                            {{-- DELETE --}}
                                            @if($user->id != Auth::id())
                                                <div class="border-t"></div>
                                                <x-table.action-delete 
                                                    :action="route('users.destroy', $user->id)"
                                                    :confirm="'Hapus user ' . $user->name . '?'"
                                                    label="Hapus User"
                                                />
                                            @endif
                                        </x-table.actions>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>