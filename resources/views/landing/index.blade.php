@extends('landing.layouts.index')
@section('title', 'Beranda | Dangau Studio')
@section('menuBeranda','active')
@section('content')


{{-- Plan 1 --}}
{{-- <section class="bg-light">
    <div class="container-fluid" style="padding-bottom: 13rem; padding-top: 5rem;">
        <div class="container">
            <div class="row flex-wrap-reverse justify-content-center align-items-center">
                <div class="col-lg-8 col-md-12 text-center text-lg-start px-5">
                    <h1 class="display-3 text-dark mb-3 fw-bold">Selamat Datang di <br><span class="display-3 fw-bold text-success">Dangau Studio</span></h1>
                    <p class="text-dark mb-4 fst-italic">" Temukan keindahan dan makna dalam karya seni terbaik dari para seniman berbakat di sini. "</p>
                    <a href="#about" class="btn btn-success btn-lg px-4 py-2">Lihat Detail</a>
                </div>
                <div class="col-lg-4 col-md-12 text-center">
                    <img src="{{ asset('assets/img/dngau.png') }}" class="img-fluid rounded-circle" alt="background" style="max-width: 350px; height: auto;">
                </div>
            </div>
        </div>
    </div>
</section> --}}


{{-- Plan 2 --}}
<section>
    <div class="container-fluid hero-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-lg-start text-center">
                    <h1 class="display-3 text-light mb-3 fw-normal">Selamat Datang di <br><span class="display-3 fw-bold" style="color: #1f991db0">Dangau Studio</span></h1>
                    <p class="text-light mb-4 fst-italic">" Temukan keindahan dan makna dalam karya seni terbaik dari para seniman berbakat di sini. "</p>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Plan 3 --}}
{{-- <section style="background-image: url({{ asset('assets/img/background.png') }}); background-size: cover; background-position: center;">
    <div class="hero-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <h1 class="display-3 text-dark mb-3 fw-bold font-monospace">Selamat Datang di <br> Dangau Studio</h1>
                    <p class="text-dark mb-4">Temukan keindahan dan makna dalam karya seni terbaik dari para seniman berbakat di sini.</p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

{{-- TentangDangau --}}
<section>
    <div class="container-fluid tentang-kami">
        <div class="container">
            <div class="row flex-wrap-reverse">
                <div class="col-lg-5 col-md-12 text-lg-start">
                    <h2 class="text-dark mb-3 fw-bold ">TENTANG <span class="text-success fs-7 mb-3 fw-bold">KAMI</span></h2>
                    <p class="text-dark mb-4 pt-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Aspernatur, nobis ipsum voluptatem perferendis veritatis unde quaerat saepe dolore ex deleniti reprehenderit repudiandae minus necessitatibus facere! Placeat, iure aspernatur! Modi esse odio placeat cumque recusandae debitis aliquid, dolorum porro ipsum quidem architecto, nam, quo quibusdam cum excepturi! Placeat, dignissimos? Blanditiis, eius?</p>
                    <p class="text-dark mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum ipsam ea libero dolorum, fuga in aperiam. Distinctio reiciendis ipsa iusto, omnis nemo totam adipisci, fugiat dolore nisi impedit, eum laboriosam fuga non tempore mollitia. Omnis repellat nulla placeat voluptatum voluptas nihil eveniet minus ratione sit reprehenderit asperiores, odit vero vel!</p>
                </div>
                <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                    <img src="{{ asset('assets/img/tentang.png') }}" class="img-fluid rounded-4" alt="background">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KaryaDangau --}}
<section>
    <div class="container-fluid karya">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">GALERY <span class="text-success fs-7 mb-3 fw-bold">SENI</span></h2>
            <div class="owl-carousel card-carousel position-relative">
                @forelse ($karyas as $karya)
                <div class="card-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $karya->image) }}" alt="{{ $karya->name }}" style="height: 300px; object-fit: cover;">
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                            <button class="btn btn-light rounded-5 btn-square mx-1">
                               {{ $karya->stock }}
                            </button>
                        </div>
                        <div class="card-body ">
                            <h4 class="">{{ $karya->name }}</h4>
                            <p class="card-text">Karya : {{ $karya->seniman->name }}</p>
                        </div>
                        <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                            {{-- <h5 class="card-text">Rp {{ number_format($karya->price, 0, ',', '.') }}</h5> --}}
                            <h5 class="card-text" style="color: #C62E2E;">Rp {{ number_format($karya->price, 0, ',', '.') }}</h5>
                            <a href="/galery/{{ $karya->slug }}" class="btn btn-success">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted fs-5 fw-bolder">Belum ada</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- SenimanDangau --}}
<section>
    <div class="container-fluid seniman">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">SENIMAN <span class="text-success fs-7 mb-3 fw-bold">KAMI</span></h2>
            <div class="owl-carousel card-carousel position-relative">
                @forelse ($senimans as $seniman)
                <div class="card-item">
                    <div class="card ">
                        <img class="card-img-top" src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="{{ $karya->name }}" style="height: 300px; object-fit: cover;">
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                            <a class="btn btn-square mx-1" href="{{ $seniman->medsos }}">
                                <i class="fab fa-instagram"></i> {{ $seniman->medsos_name }}
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="mb-3">{{ $seniman->name }}</h5>
                            <small>{!! Str::limit(strip_tags($seniman->bio), 150) !!}</small>
                        </div>
                    </div>
                    {{-- <div class="overflow-hidden">
                        <img class="img-fluid" src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="">
                    </div>
                    <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                        <a class="btn btn-square mx-1" href="{{ $seniman->medsos }}">
                            <i class="fab fa-instagram"></i> {{ $seniman->medsos_name }}
                        </a>
                    </div>
                    <div class="text-center p-4">
                        <h5 class="mb-3">{{ $seniman->name }}</h5>
                        <small>{!! Str::limit(strip_tags($seniman->bio), 150) !!}</small>
                    </div> --}}
                </div>
                @empty
                <span class="text-muted">Belum ada</span>
                @endforelse
            </div>
        </div>
    </div>
</section>


@endsection
