@extends('auth.layouts.main')
@section('title', 'Reset Password | Dangau Studio')
@section('content')

<form id="formAuthentication" class="mb-3" action="{{ route('password.store') }}" method="POST">
    @csrf
   <!-- Password Reset Token -->
  <input type="hidden" name="token" value="{{ $request->route('token') }}">
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
  <button type="submit" class="btn btn-custom w-100 fs-4 mt-4" style="background-color: #1a5319; color: #fff;">Reset Password</button>
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
