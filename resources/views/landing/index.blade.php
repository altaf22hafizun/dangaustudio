@extends('landing.layouts.index')
@section('title', 'Beranda | Dangau Studio')
@section('menuBeranda','active')
@section('content')

<section>
    <div class="container-fluid hero-header" style="padding-bottom: 8rem;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h1 class="display-3 text-white mb-3 fw-bold">Selamat Datang di <br> Dangau Studio</h1>
                    {{-- <h1 class="display-3 text-white mb-3 fw-bold font-monospace">Selamat Datang di <br> Dangau Studio</h1> --}}
                    <p class="text-white mb-4">Temukan keindahan dan makna dalam karya seni terbaik dari para seniman berbakat di sini.</p>
                </div>
            </div>
        </div>
    </div>
</section>

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
