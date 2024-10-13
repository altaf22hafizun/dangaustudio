@extends('admin.layouts.index')
@section('title', 'Edit Seniman | Admin Dangau Studio')
@section('menuSeniman','active')
@section('content')


<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Seniman</h5>
        <form action="{{ route('seniman.update', $senimans->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                     <!-- Nama Seniman -->
                     <div class="mb-3">
                        <label for="name">
                            Nama Seniman
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama Seniman" value="{{ old('name' , $senimans->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Telepon Seniman -->
                    <div class="mb-3">
                        <label for="telp">
                            Nomor Telepon Seniman
                        </label>
                        <input type="number" name="telp" id="telp"
                            class="form-control rounded-0 @error('telp') is-invalid @enderror"
                            placeholder="Masukkan telepon Seniman" value="{{ old('telp', $senimans->telp) }}">
                        @error('telp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Medsos Seniman -->
                    <div class="mb-3">
                        <label for="medsos">
                            Instagram Seniman
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="medsos" id="medsos"
                            class="form-control rounded-0 @error('medsos') is-invalid @enderror"
                            placeholder="Masukkan instagram Seniman" value="{{ old('medsos', $senimans->medsos) }}">
                        @error('medsos')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Bio Seniman -->
                    <div class="mb-3">
                        <label for="bio">
                            Biografi Seniman
                            <span class="text-danger">*</span>
                        </label>
                        <textarea id="editor" name="bio"
                            class="form-control @error('bio') is-invalid @enderror"
                            placeholder="Masukkan isi Seniman">{{ old('bio', $senimans->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_profile">
                            Foto Seniman
                            <span class="text-danger">*</span>
                        </label>
                        <img class="img-preview img-fluid mb-3 mt-2 col-sm-4">
                        <input class="form-control" type="file" name="foto_profile" id="image" onchange="previewImage()">
                        @error('foto_profile')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-3">
                <a href="{{ route('seniman.index') }}" class="btn btn-secondary rounded-3 me-3 ">Kembali</a>
                <button type="submit" class="btn btn-success rounded-3">Submit</button>
            </div>
        </form>
    </div>
</div>


@endsection

@push('custom-script')
<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFRSeniman) {
            imgPreview.src = oFRSeniman.target.result;
        }
    }
</script>
@endpush
