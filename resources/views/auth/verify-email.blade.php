<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div
            class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-white">Verifikasi Email</h2>
        <div class="text-slate-400 text-sm mt-3 leading-relaxed space-y-2">
            <p>
                {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirimkan.') }}
            </p>
            <p>
                {{ __('Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkannya kembali.') }}
            </p>
        </div>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div
            class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-medium text-center">
            {{ __('Link verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat pendaftaran.') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit"
                class="w-full relative flex justify-center py-2.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-500/30 active:scale-95">
                <span
                    class="absolute inset-0 rounded-xl bg-white/20 opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                {{ __('Kirim Ulang Email Verifikasi') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full text-sm text-slate-400 hover:text-white transition-colors py-2">
                {{ __('Keluar') }}
            </button>
        </form>
    </div>
</x-guest-layout>