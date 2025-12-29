<x-guest-layout>
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <div
            class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg shadow-indigo-500/30">
            <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 11l-4.498 4.498a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.242-2.242a1 1 0 010-1.414l.707-.707a1 1 0 011.414 0l.002.002a1 1 0 01.293.707H6.93l.315-.315a1 1 0 01.707-.293h3.172a1 1 0 01.707.293L15.657 8A2 2 0 0115 7z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold tracking-tight text-white">Lupa Password?</h2>
        <p class="text-slate-400 text-sm mt-3 leading-relaxed">
            {{ __('Jangan khawatir. Masukkan alamat email Anda dan kami akan mengirimkan link reset password.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="group">
            <x-input-label for="email" :value="__('Email')" class="sr-only" />
            <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                <div
                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-400 transition-colors">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email"
                    class="block w-full pl-11 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-sm text-white placeholder:text-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 focus:bg-white/10 transition-all duration-300 shadow-sm"
                    type="email" name="email" :value="old('email')" required autofocus placeholder="nama@email.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2 gap-4">
            <a class="text-sm font-medium text-slate-400 hover:text-white transition-colors"
                href="{{ route('login') }}">
                {{ __('Kembali') }}
            </a>

            <button type="submit"
                class="relative flex-1 flex justify-center py-2.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-slate-900 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-500/30 active:scale-95">
                <span
                    class="absolute inset-0 rounded-xl bg-white/20 opacity-0 hover:opacity-100 transition-opacity duration-300"></span>
                {{ __('Kirim Link Reset') }}
            </button>
        </div>
    </form>
</x-guest-layout>