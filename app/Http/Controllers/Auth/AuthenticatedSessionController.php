<?php

namespace App\Http\Controllers\Auth;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        // return view('auth.login');
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    public function store(LoginRequest $request): RedirectResponse
    {
        // Autentikasi dan regenerasi session
        $request->authenticate();
        $request->session()->regenerate();

        // Cek role pengguna
        if (Auth::user()->role == 'admin') {
            // Jika role admin, arahkan ke dashboard
            return redirect()->route('dashboard');
        }

        // Jika bukan admin, arahkan ke halaman home
        $redirect = redirect()->route('home');

        // Cek apakah ada parameter redirect di URL
        if ($request->has('redirect')) {
            // Jika ada redirect, arahkan ke URL yang diberikan
            return redirect()->to($request->get('redirect'));
        }

        // Kembalikan hasil redirect berdasarkan kondisi di atas
        return $redirect;
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
