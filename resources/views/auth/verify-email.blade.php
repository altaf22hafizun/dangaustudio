{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout> --}}


@extends('auth.layouts.main')
@section('title', 'Verifikasi Email | Dangau Studio')
@section('content')

<div class="mb-4">
    {{-- <h1 class="fw-bold">Lupa Kata Sandi?</h1> --}}
    <p class="text-muted"><span class="fw-bold">Terima kasih telah mendaftar! </span><br> Sebelum mulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkannya lagi.</p>
</div>

<div class="d-flex justify-content-between mb-2">
    <form id="formAuthentication" action="{{ route('verification.send') }}" method="POST" class="me-2">
        @csrf
        <button type="submit" class="btn btn-custom fs-3" style="background-color: #1a5319; color: #fff;">
            Kirim ulang email verifikasi
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}" class="align-self-center">
        @csrf
        <button type="submit" class="btn btn-link text-decoration-none fs-3">
            Logout
        </button>
    </form>
</div>



@endsection
