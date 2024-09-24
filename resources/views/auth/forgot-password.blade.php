{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

@extends('auth.layouts.main')
@section('title', 'Lupa Sandi | Dangau Studio')
@section('content')

<div class="mb-4">
    {{-- <h5 class="fw-bold">Lupa Kata Sandi?</h5> --}}
    <p class="fw-bold">Lupa Kata Sandi? <span class="text-muted fw-normal">Tidak masalah! Cukup berikan alamat email Anda dan kami akan mengirimkan tautan reset kata sandi. </span></p>
</div>

<form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
    @csrf
    <div class="mb-3 text-dark fw-bold">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control border-success @error('email') is-invalid @enderror"
               name="email" placeholder="Masukkan alamat email Anda" autofocus required />
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <button type="submit" class="btn btn-custom w-100 fs-4 my-3" style="background-color: #1a5319; color: #fff;">
        Kirim Tautan Reset
    </button>
</form>

<div class="text-center">
    <a href="/login" class="text-decoration-none">Kembali ke Halaman Masuk</a>
</div>

@endsection
