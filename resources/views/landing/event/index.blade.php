@extends('landing.layouts.index')
@section('title', 'Event | Dangau Studio')
@section('menuEvent','active')
@section('content')

{{-- EventDangau --}}
<section>
    <div class="container mt-5 px-4">
        {{-- <div class="row mb-5">
            <div class="col-lg d-flex justify-content-between align-items-center">
                <h2 class="mb-0 text-success">Event Terdekat</h2>
                {{-- <a class="btn btn-link fw-semibold text-decoration-none text-end" href="#">Lihat Semua</a>
            </div>
        </div> --}}
        <div class="nav d-flex flex-column flex-md-row mb-5 align-items-md-center">
            <h2 class="mb-3 me-md-auto text-success">Event Terdekat</h2>
            <form class="d-flex mb-3" role="search" method="GET" action="{{ route('event.landing') }}">
                <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                <button class="btn btn-success" type="submit">Cari</button>
            </form>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
            @forelse ($events as $event)
                <div class="col mb-4">
                <div class="card-item h-100">
                    <div class="card h-100 d-flex flex-column">
                        <img class="card-img-top" src="{{ Storage::url($event->image) }}" alt="{{ $event->name }}" style="object-fit: contain; height: 200px;" />
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title">{!! Str::limit(strip_tags($event->nama_event), 30) !!}</h5>
                            <p class="card-text fw-bold">{{ $event->category }}</p>
                            <small class="card-text mb-3">{!! Str::limit(strip_tags($event->description), 50) !!}</small>
                            <a href="event/{{ $event->slug }}" class="btn btn-success mt-auto">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Tidak ada event yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $events->links() }}
        </div>
    </div>
</section>

@endsection
