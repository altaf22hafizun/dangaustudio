<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan pengguna telah terautentikasi
        if (!Auth::check()) {
            return redirect('/login');
        }

        $userLevel = Auth::user()->role;

        // Periksa jika admin mencoba mengakses halaman khusus pengguna
        if ($userLevel === 'admin' && $request->is('user/*')) {
            return redirect('/admin')->with('error', 'Anda hanya memiliki akses ke halaman ini.');
        }

        // Izinkan akses jika level pengguna cocok dengan peran yang dibutuhkan
        if ($role === 'admin' && $userLevel === 'admin') {
            return $next($request);
        }

        if ($role === 'user' && $userLevel === 'user') {
            return $next($request);
        }

        // Pengalihan default jika tidak memenuhi syarat
        return redirect('/')->with('error', 'Anda hanya memiliki akses ke halaman ini.');
    }
}
