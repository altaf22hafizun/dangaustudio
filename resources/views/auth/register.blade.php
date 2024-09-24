@extends('auth.layouts.main')
@section('title', 'Register | Dangau Studio')
@section('content')

<form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
    @csrf
    <div class="mb-3 text-dark">
        <label for="name" class="form-label">Nama</label>
        <input type="name" id="name" class="form-control border-success @error('name') is-invalid @enderror" name="name" placeholder="Masukan nama anda" value="{{ old('name') }}" autofocus>
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3 text-dark">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" class="form-control border-success @error('email') is-invalid @enderror" name="email" placeholder="Masukan alamat email anda" value="{{ old('email') }}" autofocus>
        @error('email')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3 text-dark">
        <label for="telp" class="form-label">No. Telepon</label>
        <input type="tel" id="telp" class="form-control border-success @error('telp') is-invalid @enderror" name="telp" placeholder="Masukan No. Telepon" value="{{ old('telp') }}">
        @error('telp')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="mb-3 form-password-toggle text-dark">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password">Password</label>
        </div>
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
    <div class="mb-3 form-password-toggle text-dark">
        <div class="d-flex justify-content-between">
            <label class="form-label" for="password_confirmation">Confirm Password</label>
        </div>
        <div class="input-group input-group-merge">
            <input type="password" id="password_confirmation"
                class="form-control border-success @error('password') is-invalid @enderror"
                name="password_confirmation"
                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                aria-describedby="password_confirmation" />
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
        </div>
    </div>
    <div class="mb-3">
        <div class="form-check mt-3 mt-md-0">
            <input class="form-check-input" type="checkbox" id="showPassword" />
            <label class="form-check-label" for="showPassword">Tampilkan Password</label>
        </div>
    </div>
    <button type="submit" class="btn w-100 fs-4 mb-4" style="background-color: #1a5319; color: #fff;">Daftar</button>
    <div class="d-flex align-items-center justify-content-center">
        <p class="fs-4 mb-0 fw-bold">Sudah punya akun?</p>
        <a class="text-primary fw-bold ms-2" href="/login">Login di sini</a>
    </div>
</form>

@endsection

@push('custom-script')
<script>
    document.getElementById('showPassword').addEventListener('change', function() {
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');

        if (this.checked) {
            passwordInput.type = 'text'; // Show the password
            passwordConfirmationInput.type = 'text'; // Show the password confirmation
        } else {
            passwordInput.type = 'password'; // Hide the password
            passwordConfirmationInput.type = 'password'; // Hide the password confirmation
        }
    });
</script>

@endpush
