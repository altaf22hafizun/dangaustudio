{{-- @extends('landing.layouts.index')
@section('title', 'Seniman | Dangau Studio')
@section('menuSeniman','active')
@section('content')

{{-- SenimanDangau
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
 --}}

@extends('landing.layouts.index')
@section('title', 'Seniman | Dangau Studio')
@section('menuSeniman', 'active')
@section('content')

{{-- SenimanDangau --}}
<section>
    <div class="container mt-5 px-4">
        <div class="row mb-5">
            <div class="col-lg d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-success">Seniman Dangau Studio</h2>
                {{-- <a class="btn btn-link fw-semibold text-decoration-none text-end" href="#">Lihat Semua</a> --}}
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4">
            @forelse ($senimans as $seniman)
                <div class="col mb-4">
                    <div class="card-item h-100">
                        <div class="card h-100 d-flex flex-column">
                            <img class="card-img-top" src="{{ Storage::url($seniman->foto_profile) }}" alt="{{ $seniman->name }}" style="object-fit: cover; height: 200px;" />
                            <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                                <a class="btn btn-square btn-sm mx-1 rounded-5" href="{{ $seniman->medsos }}" style="min-width: 150px; font-size: 8px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    <i class="fab fa-instagram"></i> {{ $seniman->medsos_name }}
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column flex-grow-1">
                                <h5 class="card-title">{!! Str::limit(strip_tags($seniman->name), 30) !!}</h5>
                                <small class="card-text mb-3">{!! Str::limit(strip_tags($seniman->bio), 50) !!}</small>
                                <a href="seniman/{{ $seniman->slug }}" class="btn btn-success mt-auto">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada karya yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $senimans->links() }}
        </div>
    </div>
</section>

@endsection
