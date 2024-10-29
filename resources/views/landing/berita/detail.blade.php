@extends('landing.layouts.index')
@section('title', 'Detail Berita | Dangau Studio')
@section('menuBerita', 'active')
@section('content')

{{-- Berita Detail --}}
<section>
    <div class="container mt-5 px-4">
        <div class="row">
            <div class="col-lg-8 mb-4">
                <h2 class="mb-4 text-success">{{ $beritas->name }}</h2>
                <div class="row mb-2">
                    <div class="col-lg d-flex justify-content-start align-items-center">
                        <a href="{{ $beritas->link_berita }}" class="text-dark fw-bold me-3">{{ $beritas->sumber_berita }}</a>
                        <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($beritas->tgl)->format('d F Y') }}</p>
                    </div>
                </div>
                <div class="row mb-3 align-items-center">
                    <div class="col-lg d-flex justify-content-start mt-3">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($beritas->name) }}%20{{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success me-3">
                            <i class="fa-brands fa-whatsapp me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke WhatsApp</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($beritas->name) }}%20{{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success me-3">
                            <i class="fa-brands fa-twitter me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke Twitter</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success">
                            <i class="fa-brands fa-facebook me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke Facebook</span>
                        </a>
                    </div>
                </div>

                <img
                    class="img-fluid rounded mb-3 mt-5"
                    src="{{ asset('storage/' . $beritas->image) }}"
                    alt="{{ $beritas->name }}"
                    style="height: auto; width: 100%; object-fit: cover;"
                >
                <p class="card-text">{!! $beritas->description !!}</p>
                <div class="row mb-3 align-items-center">
                    <div class="col-lg d-flex justify-content-start mt-3">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($beritas->name) }}%20{{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success me-3">
                            <i class="fa-brands fa-whatsapp me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke WhatsApp</span>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($beritas->name) }}%20{{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success me-3">
                            <i class="fa-brands fa-twitter me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke Twitter</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-success">
                            <i class="fa-brands fa-facebook me-1"></i>
                            <span class="d-none d-lg-inline">Bagikan ke Facebook</span>
                        </a>
                    </div>
                </div>
                {{-- RekomendasiBerita --}}
                <div class="row my-5 align-items-center mb-4">
                    <div class="col-lg d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-success">Rekomendasi Berita</h5>
                        <a class="btn btn-link fw-semibold text-decoration-none text-success" href="{{ route('berita.landing') }}">Lihat Semua</a>
                    </div>
                </div>

                <div class="row">
                    @foreach ($rekomenBerita as $berita)
                        <div class="col-lg-6 mb-4">
                            <div class="d-flex align-items-start border p-2 rounded shadow-sm">
                                <div class="col-4 pe-3">
                                    <img
                                        class="img-fluid rounded"
                                        src="{{ asset('storage/' . $berita->image) }}"
                                        alt="{{ $berita->name }}"
                                        style="height: 100px; width: 100%; object-fit: cover;"
                                    >
                                </div>
                                <div class="col-8">
                                    <a href="/berita/{{ $berita->slug }}" class="fs-3 text-dark fw-bold mb-1">{{ $berita->name }}</a>
                                    <p class="card-text text-muted mb-0">{{ \Carbon\Carbon::parse($berita->tgl)->format('d F Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            {{-- Berita Acak --}}
            <div class="col-lg-4">
                <h5 class="mb-3 text-success">Berita Acak</h5>
                @foreach ($rekomenBerita as $berita)
                <div class="col-lg-12 mb-4">
                    <div class="d-flex align-items-start border p-2 rounded shadow-sm">
                        <div class="col-4 pe-3">
                            <img
                                class="img-fluid rounded"
                                src="{{ asset('storage/' . $berita->image) }}"
                                alt="{{ $berita->name }}"
                                style="height: 100px; width: 100%; object-fit: cover;"
                            >
                        </div>
                        <div class="col-8">
                            <a href="/berita/{{ $berita->slug }}" class="fs-3 text-dark fw-bold mb-1">{{ $berita->name }}</a>
                            <p class="card-text text-muted mb-0">{{ \Carbon\Carbon::parse($berita->tgl)->format('d F Y') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>

@endsection
