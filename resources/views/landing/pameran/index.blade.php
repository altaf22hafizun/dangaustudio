@extends('landing.layouts.index')
@section('title', 'Pameran | Dangau Studio')
@section('menuPameran','active')
@section('content')

{{-- PameranDangau --}}
<section>
    <div class="container-fluid seniman">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">PAMERAN <span class="text-success fs-7 mb-3 fw-bold">ONLINE</span></h2>
        </div>
        @forelse ($pamerans as $pameran)
        <div class="card-item">
            <div class="card">
                <img class="card-img-top" src="{{ asset('storage/' . $pameran->image) }}" alt="{{ $pameran->name }}" style="height: 300px; object-fit: contain;">
                {{-- <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                    <button class="btn btn-light rounded-5 btn-square mx-1">
                       {{ $pameran->stock }}
                    </button>
                </div> --}}
                <div class="card-body ">
                    <h4 class="card-title">{{ $pameran->name_pameran }}</h4>
                    {{-- <h5 class="card-text" style="color: #C62E2E;">Rp {{ number_format($pameran->price, 0, ',', '.') }}</h5> --}}
                    {{-- <p class="card-text fw-bold">pameran : {{ $pameran->seniman->name }}</p> --}}
                    <p class="card-text">{{ Str::limit(strip_tags($pameran->description), 100) }}</p>
                    <a href="/pameran/{{ $pameran->slug }}" class="btn btn-success">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center w-100">
            <p class="text-muted fs-5 fw-bolder">Belum ada pameran</p>
        </div>
        @endforelse
    </div>
</section>

@endsection
