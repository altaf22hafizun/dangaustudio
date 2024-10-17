<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Mengirimkan tautan reset kata sandi ke pengguna ini.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // Ambil email dari request
        $email = $request->input('email');

        return $status == Password::RESET_LINK_SENT
            ? back()->with('success', __('Tautan reset kata sandi telah dikirim ke email :email.', ['email' => $email]))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __('Gagal mengirim tautan reset kata sandi. Silakan periksa alamat email Anda.')]);
    }
}
