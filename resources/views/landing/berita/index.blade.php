@extends('landing.layouts.index')
@section('title', 'Berita | Dangau Studio')
@section('menuBerita', 'active')
@section('content')

{{-- Berita Dangau --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Berita Terbaru</h2>
        @forelse ($beritas as $berita)
            <div class="col-lg-12 mb-4">
                <div class="card-item">
                    <div class="card h-100 shadow-lg rounded border-0 overflow-hidden">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-4">
                                <img
                                    class="img-fluid"
                                    src="{{ asset('storage/' . $berita->image) }}"
                                    alt="{{ $berita->name }}"
                                    style="height: 250px; width: 100%; object-fit: cover;"
                                >
                            </div>
                            <div class="col-md-8">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold">{{ $berita->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit(strip_tags($berita->description), 150) }}</p>
                                    <p class="card-text text-muted small">{{ \Carbon\Carbon::parse($berita->tgl)->format('d F Y') }}</p>
                                    <div class="mt-auto">
                                        <a href="/berita/{{ $berita->slug }}" class="btn btn-success px-4">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada berita yang tersedia saat ini.</p>
            </div>
        @endforelse
        <div class="d-flex justify-content-center mt-4">
            {{ $beritas->links() }}
        </div>
    </div>
</section>

@endsection
