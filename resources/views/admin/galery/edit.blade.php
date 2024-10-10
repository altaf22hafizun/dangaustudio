@extends('admin.layouts.index')
@section('title', 'Edit Karya | Admin Dangau Studio')
@section('menuKarya','active')
@section('content')


<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Karya</h5>
        <form action="{{ route('karya.update', $karyas->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom pertama -->
                <div class="col-lg-6">
                    <!-- Judul Event -->
                    <div class="mb-3">
                        <label for="name">
                            Nama Karya
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="form-control rounded-0 @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama Karya" value="{{ old('name', $karyas->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Medium Karya -->
                    <div class="mb-3">
                        <label for="medium">
                            Bahan Karya
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="medium" id="medium"
                            class="form-control rounded-0 @error('medium') is-invalid @enderror"
                            placeholder="Masukkan bahan Karya" value="{{ old('medium', $karyas->medium) }}">
                        @error('medium')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Harga Karya -->
                    <div class="mb-3">
                        <label for="price">
                            Harga Karya
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="price" id="price"
                            class="form-control rounded-0 @error('price') is-invalid @enderror"
                            placeholder="Masukkan harga Karya" value="{{ old('price' , $karyas->price) }}">
                        @error('price')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Tahun Karya -->
                    <div class="mb-3">
                        <label for="tahun">
                            Tahun Karya
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="tahun" id="tahun"
                            class="form-control rounded-0 @error('tahun') is-invalid @enderror"
                            placeholder="Masukkan harga Karya" value="{{ old('tahun', $karyas->tahun) }}">
                        @error('tahun')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Kolom kedua -->
                <div class="col-lg-6">

                    <!-- Pilih Seniman -->
                    <div class="mb-3">
                        <label for="seniman_id">
                            Nama Seniman
                            <span class="text-danger">*</span>
                        </label>
                        <select name="seniman_id" id="seniman_id"
                            class="form-control rounded-0 @error('seniman_id') is-invalid @enderror">
                            <option value="" disabled selected>-- Pilih Seniman --</option>
                            @foreach ($senimans as $seniman)
                                <option value="{{ $seniman->id }}" {{ old('seniman_id', $karyas->seniman_id) == $seniman->id ? 'selected' : '' }}>
                                    {{ $seniman->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('seniman_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Size Karya -->
                    <div class="mb-3">
                        <label for="size">
                            Ukuran Karya
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="size" id="size"
                            class="form-control rounded-0 @error('size') is-invalid @enderror"
                            placeholder="Masukkan ukuran Karya" value="{{ old('size', $karyas->size) }}">
                        @error('size')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Label Berita -->
                    <div class="mb-3">
                        <label for="category">
                            Kategori Event
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="category" id="category"
                            class="form-control rounded-0 @error('category') is-invalid @enderror"
                            placeholder="Masukkan kategori Event" value="{{ old('category', $karyas->category) }}">
                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Stok Karya -->
                    <div class="mb-3">
                        <label for="stock">
                            Stock Karya
                            <span class="text-danger">*</span>
                        </label>
                        <select name="stock" class="form-control rounded-0 @error('stock') is-invalid @enderror">
                            @foreach ($stock as $key => $status)
                                <option value="{{ $key }}" {{ old('stock', $karyas->stock) == $key ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Isi Karya dan Gambar Karya -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Pilih Pameran -->
                    <div class="mb-3">
                        <label for="pameran_id">
                            Pilih Pameran
                        </label>
                        <select name="pameran_id" id="pameran_id"
                            class="form-control rounded-0 @error('pameran_id') is-invalid @enderror">
                            <option value="" disabled selected>-- Pilih Pameran --</option>
                            @foreach ($pamerans as $pameran)
                                <option value="{{ $pameran->id }}" {{ old('pameran_id', $karyas->pameran_id ) == $pameran->id ? 'selected' : '' }}>
                                    {{ $pameran->name_pameran }}
                                </option>
                            @endforeach
                        </select>
                        @error('pameran_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- Isi Karya -->
                    <div class="mb-3">
                        <label for="deskripsi">
                            Deskripsi Karya
                            <span class="text-danger">*</span>
                        </label>
                        <textarea id="editor" name="deskripsi"
                            class="form-control @error('deskripsi') is-invalid @enderror"
                            placeholder="Masukkan isi Karya">{{ old('deskripsi', $karyas->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image">
                            Gambar Karya
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
                <a href="{{ route('karya.index') }}" class="btn btn-secondary rounded-3 me-3 ">Kembali</a>
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
