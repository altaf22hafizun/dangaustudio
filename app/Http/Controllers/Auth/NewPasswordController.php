<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Menampilkan tampilan reset kata sandi.
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Menangani permintaan kata sandi baru.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'token.required' => 'Token verifikasi diperlukan.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
            'password.confirmed' => 'Kata sandi tidak sama.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        // Mencoba mereset kata sandi pengguna. Jika berhasil, kita akan
        // memperbarui kata sandi pada model pengguna dan menyimpannya ke database.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // Jika kata sandi berhasil direset, kita akan mengarahkan pengguna kembali ke
        // halaman login. Jika ada kesalahan, kita akan mengarahkan mereka kembali
        // dengan pesan kesalahan yang sesuai.
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Kata sandi Anda telah berhasil direset. Silakan login.')
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => 'Email atau token tidak valid.']);
    }
}
