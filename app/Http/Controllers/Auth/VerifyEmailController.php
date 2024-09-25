<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // if ($request->user()->hasVerifiedEmail()) {
        //     return redirect()->route('login')->with('status', 'Email Anda sudah terverifikasi.');
        // }

        // if ($request->user()->markEmailAsVerified()) {
        //     event(new Verified($request->user()));
        // }

        // return redirect()->route('login')->with('status', 'Email Anda telah terverifikasi.');

        $user = $request->user();
        if ($user->hasVerifiedEmail()) {
            return $this->redirectBaseOnRole($user);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return $this->redirectBaseOnRole($user);
    }

    protected function redirectBaseOnRole($user):RedirectResponse
    {
        $role = User::find($user->role);
        if ($role == 'admin'){
            return redirect()->route('dashboard', ['verified' => 1]);
        } else{
            return redirect()->route('home');
        }
    }
}
