<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-strong {
            background: rgba(4, 4, 30, 0.4); 
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }
        /* Custom geometric shapes animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        @keyframes drift {
            0% { transform: translate(0, 0); }
            50% { transform: translate(10px, 15px); }
            100% { transform: translate(0, 0); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        .animate-drift {
            animation: drift 8s ease-in-out infinite;
        }
        .bg-fantasy {
            background: radial-gradient(circle at 10% 20%, rgb(40, 10, 60) 0%, rgb(20, 10, 40) 40%, rgb(10, 5, 20) 90%);
        }
    </style>
</head>
<body class="font-sans antialiased text-white bg-fantasy min-h-screen overflow-x-hidden selection:bg-purple-500 selection:text-white">
    
    <!-- Background Abstract Elements -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <!-- Glowing Orbs -->
        <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-purple-600/20 rounded-full blur-[120px] mix-blend-screen animate-drift"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] bg-indigo-600/10 rounded-full blur-[100px] mix-blend-screen animate-drift" style="animation-delay: 2s;"></div>
        
        <!-- Geometric Shapes -->
        <div class="absolute top-20 left-20 w-32 h-32 rounded-full border-4 border-purple-500/10 hidden lg:block animate-float"></div>
        <div class="absolute bottom-40 left-1/4 w-20 h-20 rounded-full bg-indigo-500/10 hidden lg:block animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/3 right-1/3 w-64 h-64 rounded-full border border-white/5 hidden lg:block"></div>
        
        <!-- Noise Texture -->
        <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20 brightness-100 contrast-150 mix-blend-overlay"></div>
    </div>

    <div class="relative z-10 flex min-h-screen">
        <!-- Left Side: Welcome Text -->
        <div class="hidden lg:flex w-1/2 flex-col justify-center px-20 relative">
            <div class="relative z-10 space-y-4">
                <h1 class="text-6xl font-black tracking-tight leading-none bg-clip-text text-transparent bg-gradient-to-r from-white via-purple-100 to-purple-300 drop-shadow-lg">
                    Sistem Inventaris
                    <span class="block text-4xl mt-2 font-bold text-purple-300/80">Kampus Digital</span>
                </h1>
                <p class="text-xl text-purple-200/80 font-light tracking-wide max-w-lg leading-relaxed mt-4">
                    Kelola aset kampus dengan tingkat efisiensi dan transparansi yang lebih tinggi.
                </p>
                <div class="h-1 w-20 bg-purple-500 rounded-full mt-6"></div>
            </div>
        </div>

        <!-- Right Side: Login Card -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-12">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
