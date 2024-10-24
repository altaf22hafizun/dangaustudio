@extends('landing.layouts.index')
@section('title', 'Detail Karya | Dangau Studio')
@section('menuGalery', 'active')
@section('content')

{{-- Detail Karya --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success text-center">Detail Karya</h2>
        <div class="row">
            <div class="col-lg-5 col-md-12 text-center mb-5">
                <img src="{{ Storage::url($karya->image) }}" class="img-fluid rounded-4" alt="{{ $karya->name }}" style="max-height: 500px; object-fit: contain;">
            </div>
            <div class="col-lg-6 col-md-12 ms-auto">
                <h4 class="mb-3 text-success">{{ $karya->name }}</h4>
                <p class="text-dark fw-bold mb-3">Karya: {{ $karya->seniman->name }}</p>
                <p class="text-dark fw-bold">Media: {{ $karya->medium }}</p>
                <p class="text-dark fw-bold">Size: {{ $karya->size }}</p>
                <p class="text-dark fw-bold">Tahun: {{ $karya->tahun }}</p>
                {{-- <p class="text-dark fw-bold">Deskripsi: {!! $karya->deskripsi !!}</p> --}}
                @if ($karya->stock == 'Terjual')
                <h3 class="text-danger mb-3">TERJUAL</h3>
                @else
                <h3 class="text-danger mb-3">Rp {{ number_format($karya->price, 0, ',', '.') }}</h3>
                @endif
                <div class="d-flex justify-content-start align-items-center mt-5">
                    @if ($karya->stock == 'Tersedia')
                        <a class="btn btn-success me-3" href="{{ $karya->price }}" style="min-width: 150px;">
                            <i class="fa fa-cart-plus me-2"></i> Masukkan Keranjang
                        </a>
                        <a class="btn btn-danger" href="{{ $karya->price }}" style="min-width: 150px;">
                            <i class="fa fa-shopping-cart me-2"></i> Beli Sekarang
                        </a>
                    @else
                        <button class="btn btn-danger me-3 w-100" disabled>
                            <i class="fa fa-cart-plus me-2"></i> Barang terjual
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <p class="text-dark fw-bold mt-5">Deskripsi: {!! $karya->deskripsi !!}</p>
        {{-- <a href="/galery" class="btn btn-success mt-5"><i class="fa-solid fa-angle-left me-2"></i>Kembali</a> --}}
    </div>
</section>

@endsection
