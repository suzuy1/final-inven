<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans text-slate-100 antialiased bg-slate-900 selection:bg-indigo-500 selection:text-white overflow-hidden">
    <!-- Animated Background -->
    <div class="fixed inset-0 -z-10">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/30 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-purple-600/30 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-600/30 rounded-full mix-blend-screen filter blur-3xl opacity-30 animate-blob animation-delay-4000">
        </div>
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150">
        </div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative">
        <!-- Card Container -->
        <div
            class="w-full sm:max-w-md px-8 py-10 bg-white/5 backdrop-blur-xl shadow-2xl ring-1 ring-white/10 sm:rounded-3xl relative overflow-hidden group transition-all duration-500 hover:shadow-indigo-500/10 hover:ring-white/20">
            <!-- Decorative Top Gradient Line -->
            <div
                class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-indigo-500 to-transparent opacity-50">
            </div>

            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-slate-500 text-sm font-medium tracking-wide">
            &copy; {{ date('Y') }} SIM Inventaris System
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>