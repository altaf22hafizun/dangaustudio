@extends('landing.layouts.index')
@section('title', 'Beranda | Dangau Studio')
@section('menuBeranda','active')
@section('content')


{{-- Plan 1 --}}
<section class="bg-light">
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
</section>


{{-- Plan 2 --}}
{{-- <section>
    <div class="container-fluid hero-header" style="padding-bottom: 8rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h1 class="display-3 text-white mb-3 fw-bold">Selamat Datang di <br> Dangau Studio</h1>
                    <p class="text-white mb-4">Temukan keindahan dan makna dalam karya seni terbaik dari para seniman berbakat di sini.</p>
                </div>
            </div>
        </div>
    </div>
</section> --}}

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

@endsection
