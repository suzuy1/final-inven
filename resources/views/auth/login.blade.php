<x-auth-split-layout>
    <div class="glass-strong p-8 sm:p-12 rounded-[2rem] w-full max-w-md relative overflow-hidden group">
        <!-- Card Inner Decoration -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-2xl -mr-16 -mt-16 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl -ml-16 -mb-16 pointer-events-none"></div>

        <!-- Status Session -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6 relative z-10">
            @csrf

            <!-- Username / Email -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-purple-100 pl-1">
                    {{ __('Username / Email') }}
                </label>
                <div class="relative">
                    <input id="email" 
                        class="block w-full px-5 py-4 bg-white/5 border border-purple-200/10 rounded-xl text-white placeholder-purple-300/30 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:bg-white/10 transition-all duration-300 backdrop-blur-sm" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                        placeholder="John Doe" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-purple-100 pl-1">
                    {{ __('Password') }}
                </label>
                <div class="relative">
                    <input id="password" 
                        class="block w-full px-5 py-4 bg-white/5 border border-purple-200/10 rounded-xl text-white placeholder-purple-300/30 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 focus:bg-white/10 transition-all duration-300 backdrop-blur-sm"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                        placeholder="••••••••" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-2">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox" 
                        class="rounded border-purple-200/20 bg-white/5 text-purple-600 focus:ring-purple-500 focus:ring-offset-0 transition-colors" 
                        name="remember">
                    <span class="ms-2 text-sm text-purple-200 hover:text-white transition-colors">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                class="w-full py-4 px-6 rounded-xl text-sm font-bold tracking-wider text-white uppercase bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 focus:ring-offset-gray-900 transition-all duration-300 transform hover:-translate-y-1 shadow-lg shadow-purple-900/40">
                {{ __('Sign In') }}
            </button>

            <!-- Sign Up Link -->
            <div class="text-center pt-4 text-sm text-purple-200/60">
                Don't have an account? 
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="font-bold text-white hover:text-purple-300 transition-colors underline decoration-purple-500/50 hover:decoration-purple-300">
                        {{ __('Sign Up') }}
                    </a>
                @endif
            </div>

            @if (Route::has('password.request'))
                <div class="text-center mt-2">
                    <a class="text-xs text-purple-300/50 hover:text-purple-200 transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot Password') }}
                    </a>
                </div>
            @endif
        </form>
    </div>
</x-auth-split-layout>