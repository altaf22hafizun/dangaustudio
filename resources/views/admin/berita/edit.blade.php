@extends('admin.layouts.index')
@section('title', 'Edit Berita | Admin Dangau Studio')
@section('menuBerita','active')
@section('content')

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Berita</h5>
        <form action="{{ route('berita.update', $beritas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom pertama -->
                <div class="col-lg-6">
                    <!-- Judul Berita -->
                    <div class="mb-3">
                        <label for="name">
                            Judul Berita
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror"
                            placeholder="Masukkan judul Berita" value="{{ old('name', $beritas->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Publikasi -->
                    <div class="mb-3">
                        <label for="tgl">
                            Tanggal Publikasi
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="tgl" id="tgl"
                            class="form-control rounded-0 @error('tgl') is-invalid @enderror"
                            value="{{ old('tgl', $beritas->tgl) }}">
                        @error('tgl')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Sumber Berita -->
                    <div class="mb-3">
                        <label for="sumber_berita">
                            Sumber Berita
                        </label>
                        <input type="text" name="sumber_berita" id="sumber_berita"
                            class="form-control rounded-0 @error('sumber_berita') is-invalid @enderror"
                            placeholder="Masukkan sumber Berita" value="{{ old('sumber_berita', $beritas->sumber_berita) }}">
                        @error('sumber_berita')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom kedua -->
                <div class="col-lg-6">
                    <!-- Label Berita -->
                    <div class="mb-3">
                        <label for="label_berita">
                            Label Berita
                        </label>
                        <input type="text" name="label_berita" id="label_berita"
                            class="form-control rounded-0 @error('label_berita') is-invalid @enderror"
                            placeholder="Masukkan label Berita" value="{{ old('label_berita', $beritas->label_berita) }}">
                        @error('label_berita')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Link Berita -->
                    <div class="mb-3">
                        <label for="link_berita">
                            Link Berita
                        </label>
                        <input type="text" name="link_berita" id="link_berita"
                            class="form-control rounded-0 @error('link_berita') is-invalid @enderror"
                            placeholder="Masukkan link Berita" value="{{ old('link_berita', $beritas->link_berita) }}">
                        @error('link_berita')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status Publikasi -->
                    <div class="mb-3">
                        <label for="status_publikasi">
                            Status Publikasi
                        </label>
                        <select name="status_publikasi" class="form-control rounded-0 @error('status_publikasi') is-invalid @enderror">
                            @foreach ($status_publikasi as $key => $status)
                                <option value="{{ $key }}" {{ old('status_publikasi', $beritas->status_publikasi) == $key ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_publikasi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Isi Berita dan Gambar Berita -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Isi Berita -->
                    <div class="mb-3">
                        <label for="description">
                            Isi Berita
                            <span class="text-danger">*</span>
                        </label>
                        <textarea id="editor" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Masukkan isi berita">{{ old('description', $beritas->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image">
                            Gambar Berita
                            <span class="text-danger">*</span>
                        </label>
                        <img class="img-preview img-fluid mb-3 mt-2 col-sm-4">
                        <input class="form-control" type="file" name="image" id="image" onchange="previewImage()">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-3">
                <a href="{{ route('berita.index') }}" class="btn btn-secondary rounded-3 me-3 ">Kembali</a>
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

        oFReader.onload = function(oFRBerita) {
            imgPreview.src = oFRBerita.target.result;
        }
    }
</script>
@endpush
