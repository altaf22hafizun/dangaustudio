@extends('admin.layouts.index')
@section('title', 'Edit Pameran | Admin Dangau Studio')
@section('menuPameran','active')
@section('content')


<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Pameran</h5>
        <form action="{{ route('pameran.update', $pamerans->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom pertama -->
                <div class="col-lg-6">
                    <!-- Judul Pameran -->
                    <div class="mb-3">
                        <label for="name">
                            Nama Pameran
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name_pameran" id="name_pameran"
                            class="form-control rounded-0 @error('name_pameran') is-invalid @enderror"
                            placeholder="Masukkan judul Pameran" value="{{ old('name_pameran', $pamerans->name_pameran) }}">
                        @error('name_pameran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tanggal Mulai Pameran -->
                    <div class="mb-3">
                        <label for="start_date">
                            Tanggal Mulai Pameran
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date"
                            class="form-control rounded-0 @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $pamerans->start_date) }}">
                        @error('start_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom kedua -->
                <div class="col-lg-6">
                    <!-- Status Publikasi -->
                    <div class="mb-3">
                        <label for="status_publikasi">
                            Status Publikasi
                            <span class="text-danger">*</span>
                        </label>
                        <select name="status_publikasi" class="form-control rounded-0 @error('status_publikasi') is-invalid @enderror">
                            @foreach ($status_publikasi as $key => $status)
                                <option value="{{ $key }}" {{ old('status_publikasi', $pamerans->status_publikasi) == $key ? 'selected' : '' }}>
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
                    <!-- Tanggal Berakhir Pameran -->
                    <div class="mb-3">
                        <label for="end_date">
                            Tanggal Berakhir Pameran
                            <span class="text-danger">*</span>
                        </label>
                        <input type="date" name="end_date" id="end_date"
                            class="form-control rounded-0 @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date',$pamerans->end_date) }}">
                        @error('end_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Isi Pameran dan Gambar Pameran -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Isi Pameran -->
                    <div class="mb-3">
                        <label for="description">
                            Deskripsi Pameran
                            <span class="text-danger">*</span>
                        </label>
                        <textarea id="editor" name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Masukkan isi Pameran">{{ old('description', $pamerans->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image">
                            Gambar Pameran
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
                <a href="{{ route('pameran.index') }}" class="btn btn-secondary rounded-3 me-3 ">Kembali</a>
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

        oFReader.onload = function(oFRKarya) {
            imgPreview.src = oFRKarya.target.result;
        }
    }
</script>
@endpush
