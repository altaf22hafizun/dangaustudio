@extends('landing.layouts.index')
@section('title', 'Detail Pameran | Dangau Studio')
@section('menuPameran','active')
@section('content')

{{-- PameranDangau --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success text-center">{{ $pamerans->name_pameran }}</h2>
        <div class="row">
            <div class="col-lg-5 col-md-12 d-flex align-items-center justify-content-center mb-5">
                <img src="{{ Storage::url($pamerans->image) }}" class="img-fluid rounded-4" alt="{{ $pamerans->name }}" style="max-height: 500px; object-fit: contain;">
            </div>
            <div class="col-lg-6 col-md-12 ms-auto">
                <h4 class="mb-3 text-success">{{ $pamerans->nama_event }}</h4>
                <p class="text-dark fw-bold">{{ $pamerans->category }}</p>
                <p class="text-dark fw-bold">Lokasi: {{ $pamerans->location }}</p>
                <p class="text-dark fw-bold">Tanggal: {{ $pamerans->start_date }} s/d {{ $pamerans->end_date }}</p>
                <p class="text-dark fw-bold mt-3">Deskripsi: {!! $pamerans->description !!}</p>
            </div>
        </div>
        {{-- <a href="/galery" class="btn btn-success mt-5"><i class="fa-solid fa-angle-left me-2"></i>Kembali</a> --}}
    </div>
</section>

@endsection
