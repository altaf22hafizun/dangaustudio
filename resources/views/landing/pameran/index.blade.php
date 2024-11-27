@extends('landing.layouts.index')
@section('title', 'Pameran | Dangau Studio')
@section('menuPameran','active')
@section('content')

{{-- PameranDangau --}}
<section>
    <div class="container mt-5 px-4">
        {{-- <div class="row mb-5">
            <div class="col-lg d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-success">Pameran Online</h2>
                {{-- <a class="btn btn-link fw-semibold text-decoration-none text-end" href="#">Lihat Semua</a>
                <form class="d-flex mb-3" role="search" method="GET" action="{{ route('karya.index') }}">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit">Cari</button>
                </form>
            </div>
        </div> --}}
        <div class="nav d-flex flex-column flex-md-row mb-5 align-items-md-center">
            <h2 class="mb-3 me-md-auto text-success">Pameran Online</h2>
            {{-- <form class="d-flex mb-3" role="search" method="GET" action="{{ route('pameran.landing') }}">
                <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                <button class="btn btn-success" type="submit">Cari</button>
            </form> --}}
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
            @forelse ($pamerans as $karya)
                <div class="col mb-4">
                <div class="card-item h-100">
                    <div class="card h-100 d-flex flex-column">
                        <img class="card-img-top" src="{{ Storage::url($karya->image) }}" alt="{{ $karya->name }}" style="object-fit: contain; height: 200px;" />
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title">{{ $karya->name_pameran }}</h5>
                            <small class="card-text mb-3">{!! Str::limit(strip_tags($karya->description), 50) !!}</small>
                            <a href="pameran/{{ $karya->slug }}" class="btn btn-success mt-auto">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            @empty
                <div class="col-12 text-center mt-3">
                    <p class="text-muted">Tidak ada pameran yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $pamerans->links() }}
        </div>
    </div>
</section>

@endsection
