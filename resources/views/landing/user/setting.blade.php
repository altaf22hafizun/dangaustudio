@extends('landing.layouts.index')
@section('title', 'Pengaturan Profile| Dangau Studio')

@section('content')
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Pengaturan Akun</h2>
        <div class="row">
            <div class="col-md-12">
                <!-- Formulir Edit Profil -->
                <form method="POST" action="/user/account/edit-profile" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: var(--primary);">
                            <h5 class="text-light mb-0 py-2 fw-normal">Detail Profile</h5>
                        </div>
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                <img src="{{ Auth()->user()->foto_profile ? asset('storage/' . Auth()->user()->foto_profile) : asset('assets/img/foto-profile.png') }}"
                                    alt="user-avatar"
                                    class="d-block rounded ms-3 mb-3"
                                    height="auto"
                                    width="100"
                                    id="uploadedAvatar"
                                />
                                <div class="d-flex align-items-start align-items-sm-center">
                                    <!-- Tombol Upload -->
                                    <label for="upload" class="btn btn-primary me-2 mb-4 d-flex align-items-center">
                                        <i class="fa fa-upload me-2"></i>
                                        <span class="d-none d-sm-block">Upload Gambar</span>
                                        <input type="file" id="upload" name="foto_profile" class="account-file-input" hidden />
                                    </label>

                                    <!-- Tombol Reset -->
                                    <button type="button" class="btn btn-danger d-flex align-items-center mb-4" id="resetImage">
                                        <i class="fa fa-undo me-2"></i>
                                        <span class="d-none d-sm-block">Atur Ulang</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr class="my-0" />
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', Auth()->user()->name) }}" />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input class="form-control @error('telp') is-invalid @enderror" type="text" name="telp" value="{{ old('telp', Auth()->user()->telp) }}" />
                                    @error('telp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat" value="{{ old('alamat', Auth()->user()->alamat) }}" placeholder="Masukan alamat anda"/>
                                    {{-- <input class="form-control @error('alamat') is-invalid @enderror" type="text" name="alamat" value="{{ old('alamat', Auth()->user()->alamat) }}" placeholder="ex: Jl. Contoh No. XX, Kota X, Provinsi X"/> --}}
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', Auth()->user()->email) }}" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 my-3">
                                    <button type="submit" class="btn me-2 text-light" style="background-color: var(--primary);">Simpan Perubahan</button>
                                    <a href="/" class="btn btn-danger btn-block">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Formulir Ubah Password -->
                <form method="POST" action="/user/account/update-password">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header" style="background-color: var(--primary);">
                            <h5 class="text-light mb-0 py-2 fw-normal">Ubah Password</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="konfirmasipassword" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="konfirmasipassword" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" id="showPassword" />
                                <label class="form-check-label" for="showPassword"> Tampilkan Password </label>
                            </div>
                            <div class="row">
                                <div class="col-md-12 my-3">
                                    <button type="submit" class="btn me-2 text-light" style="background-color: var(--primary);">Simpan Perubahan</button>
                                    <a href="/" class="btn btn-danger btn-block">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


@push('custom-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handling image upload preview and reset
        const input = document.getElementById('upload');
        const uploadedAvatar = document.getElementById('uploadedAvatar');
        const resetButton = document.getElementById('resetImage');

        input.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function() {
                    uploadedAvatar.src = reader.result;
                }

                reader.readAsDataURL(file);
            }
        });

        resetButton.addEventListener('click', function() {
            uploadedAvatar.src = "{{ Auth()->user()->foto_profile ? asset('storage/' . Auth()->user()->foto_profile) : asset('assets/img/foto-profile.png') }}";
            input.value = ""; // Clear the file input
        });

        // Show/Hide password functionality
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordInput = document.getElementById('password');
            const passwordConfirmationInput = document.getElementById('konfirmasipassword');

            if (this.checked) {
                passwordInput.type = 'text'; // Show the password
                passwordConfirmationInput.type = 'text'; // Show the password confirmation
            } else {
                passwordInput.type = 'password'; // Hide the password
                passwordConfirmationInput.type = 'password'; // Hide the password confirmation
            }
        });
    });
</script>
@endpush

@endsection
