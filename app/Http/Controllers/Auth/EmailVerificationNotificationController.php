<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        // Cek apakah email sudah terverifikasi
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('login', absolute: false))
                ->with('status', 'Email Anda sudah terverifikasi.');
        }

        // Mengirim notifikasi verifikasi email
        $request->user()->sendEmailVerificationNotification();

        // Kembali ke halaman sebelumnya dengan pesan
        return back()->with('status', 'Tautan verifikasi telah dikirim.');
    }
}
