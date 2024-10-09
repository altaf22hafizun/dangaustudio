@extends('admin.layouts.index')
@section('title', 'Tambah Event | Admin Dangau Studio')
@section('menuEvent','active')
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tambah Event</h5>
            <form action="{{ route('events.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Kolom pertama -->
                    <div class="col-lg-6">
                        <!-- Judul Event -->
                        <div class="mb-3">
                            <label for="name">
                                Nama Event
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_event" id="nama_event"
                                class="form-control rounded-0 @error('nama_event') is-invalid @enderror"
                                placeholder="Masukkan judul Event" value="{{ old('nama_event') }}">
                            @error('nama_event')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tanggal Mulai Event -->
                        <div class="mb-3">
                            <label for="start_date">
                                Tanggal Mulai Event
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="start_date" id="start_date"
                                class="form-control rounded-0 @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Lokasi Event -->
                        <div class="mb-3">
                            <label for="location">
                                Lokasi Event
                            </label>
                            <input type="text" name="location" id="location"
                                class="form-control rounded-0 @error('location') is-invalid @enderror"
                                placeholder="Masukkan lokasi Event" value="{{ old('location') }}">
                            @error('location')
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
                            <label for="category">
                                Kategori Event
                            </label>
                            <input type="text" name="category" id="category"
                                class="form-control rounded-0 @error('category') is-invalid @enderror"
                                placeholder="Masukkan kategori Event" value="{{ old('category') }}">
                            @error('category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Tanggal Berakhir Event -->
                        <div class="mb-3">
                            <label for="end_date">
                                Tanggal Berakhir Event
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date"
                                class="form-control rounded-0 @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date') }}">
                            @error('end_date')
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
                            <select name="status_publikasi" id="status_publikasi"
                                class="form-control rounded-0 @error('status_publikasi') is-invalid @enderror">
                                <option value="Hidden" {{ old('status_publikasi') == 'Hidden' ? 'selected' : '' }}>Hidden</option>
                                <option value="Published" {{ old('status_publikasi') == 'Published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status_publikasi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Isi Event dan Gambar Event -->
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Isi Event -->
                        <div class="mb-3">
                            <label for="description">
                                Deskripsi Event
                                <span class="text-danger">*</span>
                            </label>
                            <textarea id="editor" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan isi event">{{ old('description') }}</textarea>
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
                    <a href="{{ route('events.index') }}" class="btn btn-secondary rounded-3 me-3 ">Kembali</a>
                    <button type="submit" class="btn btn-success rounded-3">Submit</button>
                </div>
            </form>
        </div>
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

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endpush
