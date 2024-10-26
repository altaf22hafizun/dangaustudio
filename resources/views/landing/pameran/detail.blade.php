@extends('landing.layouts.index')
@section('title', 'Detail Pameran | Dangau Studio')
@section('menuPameran','active')
@section('content')

{{-- PameranDangau --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success text-center">{{ $pamerans->name_pameran }}</h2>
        <div class="row">
            <div class="col-lg-6 col-md-12 ms-auto">
                <h4 class="mb-3 text-success">{{ $pamerans->nama_event }}</h4>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
            @forelse ($karyas as $karya)
                <div class="col mb-4">
                    <div class="card h-100 position-relative">
                        <img class="card-img-top" src="{{ Storage::url($karya->image) }}" alt="{{ $karya->name }}" style="object-fit: contain; height: 200px;" />
                        <div class="overlay d-flex align-items-center justify-content-center">
                            <div class="text-center text-white">
                                <p><strong>Seniman:</strong> {{ $karya->seniman->name }}</p>
                                <p><strong>Tahun:</strong> {{ $karya->tahun }}</p>
                                <p><strong>Ukuran:</strong> {{ $karya->size }}</p>
                                <p><strong>Media:</strong> {{ $karya->medium }}</p>
                                <a href="/galery/{{ $karya->slug }}" class="btn btn-light mt-2">Lihat Detail</a>
                            </div>
                        </div>
                        <div class="card-body d-flex flex-column flex-grow-1">
                            <h5 class="card-title">{!! Str::limit(strip_tags($karya->name), 30) !!}</h5>
                            <small class="card-text">{!! Str::limit(strip_tags($karya->deskripsi), 50) !!}</small>
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
            {{ $karyas->links() }}
        </div>
    </div>
</section>

@endsection
