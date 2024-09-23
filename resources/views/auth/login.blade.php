@extends('auth.layouts.main')
@section('title', 'Login | Dangau Studio')
@section('content')

<form id="formAuthentication" class="mb-3" action="/login" method="POST">
    @csrf
  <div class="mb-3 text-dark fw-bold">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" class="form-control border-success @error('email') is-invalid @enderror"
        name="email" placeholder="Masukan alamat email anda" autofocus />
    @error('email')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
  </div>
  <div class="mb-4 text-dark fw-bold">
    <label for="password" class="form-label">Password</label>
    <div class="input-group input-group-merge">
        <input type="password" id="password"
            class="form-control border-success @error('password') is-invalid @enderror"
            name="password"
            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
            aria-describedby="password" />
        @error('password')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
  </div>
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div class="form-check">
        <input class="form-check-input primary" type="checkbox" id="remember" />
        <label class="form-check-label" for="remember">Ingat saya</label>
    </div>
    <a class="text-primary fw-bold" href="{{ route('password.request') }}" id="forgotPasswordLink">Lupa Password ?</a>
  </div>
  <button type="submit" class="btn btn-custom w-100 fs-4 mb-4" style="background-color: #1a5319; color: #fff;">Masuk</button>
  <div class="d-flex align-items-center justify-content-center">
    <p class="fs-4 mb-0 fw-bold">Belum punya akun?</p>
    <a class="text-primary fw-bold ms-2" href="/register">Daftar di sini</a>
  </div>
</form>

@endsection
