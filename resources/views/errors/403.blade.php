<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header dengan gradient -->
            <div class="bg-gradient-to-r from-rose-500 to-rose-600 p-8 text-center">
                <div
                    class="inline-flex items-center justify-center w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full mb-4">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-6xl font-bold text-white mb-2">403</h1>
                <p class="text-rose-100 text-xl font-semibold">Akses Ditolak</p>
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="bg-rose-50 border-l-4 border-rose-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-rose-500 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-rose-800 font-bold mb-1">Anda Tidak Memiliki Izin</h3>
                            <p class="text-rose-700 text-sm">
                                @if(isset($exception) && $exception->getMessage())
                                    {{ $exception->getMessage() }}
                                @else
                                    Halaman yang Anda coba akses hanya dapat diakses oleh Administrator.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 mb-6">
                    <h3 class="font-bold text-slate-800 text-lg">Mengapa ini terjadi?</h3>
                    <ul class="space-y-2 text-slate-600">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Anda login sebagai <strong>User Biasa</strong>, bukan Administrator</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Fitur ini memerlukan hak akses khusus untuk keamanan sistem</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-indigo-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Hubungi Administrator jika Anda memerlukan akses ini</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-indigo-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="text-sm text-slate-700">
                            <strong class="font-semibold">Info Akun Anda:</strong><br>
                            Nama: <span class="font-medium">{{ Auth::user()->name }}</span><br>
                            Email: <span class="font-medium">{{ Auth::user()->email }}</span><br>
                            Role: <span
                                class="inline-block px-2 py-0.5 bg-slate-200 text-slate-700 rounded text-xs font-bold mt-1">{{ ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <button onclick="window.history.back()"
                        class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-3 px-6 rounded-lg transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Halaman Sebelumnya
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-slate-500 text-sm">
            <p>SIM Inventaris &copy; {{ date('Y') }} - Sistem Informasi Manajemen Inventaris</p>
        </div>
    </div>
</body>

</html>