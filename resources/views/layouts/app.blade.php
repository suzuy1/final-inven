<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Select2 JS (jQuery required) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('styles')
    @stack('scripts')
</head>

<body class="font-sans antialiased bg-slate-50 text-slate-600" x-data="{ sidebarOpen: false, pageLoading: false }">

    {{-- MODERN LOADING INDICATOR --}}
    <template x-if="pageLoading">
        <div class="print:hidden">
            {{-- Top Progress Bar (YouTube/Instagram style) --}}
            <div class="fixed top-0 left-0 right-0 z-[100] h-1 bg-indigo-100/50">
                <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 loading-progress"></div>
            </div>

            {{-- Floating Loader (glassmorphism) --}}
            <div class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[100] sm:bottom-8">
                <div
                    class="bg-white/90 backdrop-blur-xl rounded-full px-5 py-3 shadow-xl border border-white/50 flex items-center gap-3">
                    {{-- Bouncing Dots --}}
                    <div class="flex items-center gap-1">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full animate-bounce"
                            style="animation-delay: 0ms;"></span>
                        <span class="w-2 h-2 bg-purple-500 rounded-full animate-bounce"
                            style="animation-delay: 150ms;"></span>
                        <span class="w-2 h-2 bg-pink-500 rounded-full animate-bounce"
                            style="animation-delay: 300ms;"></span>
                    </div>
                    <span class="text-sm font-medium text-slate-600">Memuat</span>
                </div>
            </div>
        </div>
    </template>

    {{-- WRAPPER SIDEBAR: Sembunyikan total saat print --}}
    <div class="print:hidden">
        @include('layouts.sidebar')
    </div>

    {{-- MAIN CONTENT WRAPPER --}}
    {{-- Perhatikan penambahan class: print:ml-0 print:p-0 --}}
    <div id="main-content"
        class="p-2 sm:p-4 sm:ml-64 min-h-screen flex flex-col print:ml-0 print:p-0 transition-all duration-300">

        {{-- HEADER: Sembunyikan saat print --}}
        <header
            class="mb-3 sm:mb-6 bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30 rounded-lg sm:rounded-xl px-3 sm:px-6 py-2 sm:py-4 flex justify-between items-center shadow-sm print:hidden">

            {{-- Left Side: Hamburger + Title --}}
            <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">
                {{-- Mobile Hamburger Button --}}
                <button @click="sidebarOpen = true"
                    class="sm:hidden p-1.5 -ml-1 text-slate-600 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition-colors flex-shrink-0"
                    aria-label="Open sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- Page Title/Header - Truncate on mobile --}}
                <div class="flex-1 min-w-0 text-sm sm:text-base truncate">
                    {{ $header ?? 'SIM Inventaris' }}
                </div>
            </div>

            {{-- Right Side: User Info (Compact on mobile) --}}
            <div class="flex items-center gap-2 sm:gap-4 ml-2 sm:ml-4 flex-shrink-0">
                <div class="text-sm text-right hidden sm:block">
                    <div class="font-medium text-slate-700">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
                <div
                    class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm sm:text-lg border-2 border-white shadow-sm">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-grow">
            {{-- ALERTS: Sembunyikan saat print --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3 shadow-sm print:hidden"
                    role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Sukses</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl shadow-sm print:hidden"
                    role="alert">
                    <div class="flex items-center gap-3 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="font-bold">Terjadi Kesalahan</p>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-9">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="fade-in print:animate-none">
                {{ $slot }}
            </div>
        </main>

        {{-- FOOTER: Sembunyikan saat print --}}
        <footer class="mt-10 py-6 text-center text-xs text-slate-400 print:hidden">
            &copy; {{ date('Y') }} SIM Inventaris. All rights reserved.
        </footer>
    </div>

    {{-- Navigation Loading Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Get Alpine component data
            const body = document.body;

            // Listen for clicks on navigation links
            document.addEventListener('click', function (e) {
                const link = e.target.closest('a');

                // Check if it's a valid navigation link
                if (link &&
                    link.href &&
                    !link.href.startsWith('#') &&
                    !link.href.startsWith('javascript:') &&
                    !link.hasAttribute('download') &&
                    link.target !== '_blank' &&
                    !link.href.includes('logout') &&
                    link.href.startsWith(window.location.origin)) {

                    // Show loading overlay via Alpine
                    if (typeof Alpine !== 'undefined') {
                        Alpine.store('loading', true);
                        body._x_dataStack[0].pageLoading = true;

                        // Also close sidebar on mobile
                        body._x_dataStack[0].sidebarOpen = false;
                    }
                }
            });

            // Handle form submissions
            document.addEventListener('submit', function (e) {
                const form = e.target;
                // Don't show loading for forms with file uploads (they have their own progress)
                if (!form.querySelector('input[type="file"]')) {
                    if (typeof Alpine !== 'undefined' && body._x_dataStack) {
                        body._x_dataStack[0].pageLoading = true;
                    }
                }
            });

            // Hide loading when page is fully loaded (for back/forward navigation)
            window.addEventListener('pageshow', function (e) {
                if (e.persisted && typeof Alpine !== 'undefined' && body._x_dataStack) {
                    body._x_dataStack[0].pageLoading = false;
                }
            });
        });
    </script>
</body>

</html>