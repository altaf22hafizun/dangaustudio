@extends('landing.layouts.index')
@section('title', 'Seniman | Dangau Studio')
@section('menuSeniman','active')
@section('content')

{{-- SenimanDangau --}}
<section>
    <div class="container-fluid seniman">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">SENIMAN <span class="text-success fs-7 mb-3 fw-bold">KAMI</span></h2>
            <div class="row">
                @forelse ($senimans as $seniman)
                <div class="col-12 col-sm-6 col-md-4 mb-4">
                    <div class="card-item">
                        <div class="card h-100">
                            <img class="card-img-top" src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="{{ $seniman->name }}" style="height: 300px; object-fit: cover;">
                            <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                                <a class="btn btn-square mx-1 rounded-5" href="{{ $seniman->medsos }}">
                                    <i class="fab fa-instagram"></i> {{ $seniman->medsos_name }}
                                </a>
                            </div>
                            <div class="card-body text-center">
                                <h5 class="mb-3">{{ $seniman->name }}</h5>
                                <small class="mb-3">{!! Str::limit(strip_tags($seniman->bio), 100) !!}</small>
                                <a href="seniman/{{ $seniman->slug }}" class="btn btn-success">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <span class="text-muted">Belum ada</span>
                </div>
                @endforelse
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $senimans->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
