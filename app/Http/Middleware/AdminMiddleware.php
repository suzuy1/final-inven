<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            abort(403, 'Anda harus login terlebih dahulu.');
        }

        // Cek apakah user memiliki role admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya Administrator yang dapat mengakses halaman ini.');
        }

        return $next($request);
    }
}
