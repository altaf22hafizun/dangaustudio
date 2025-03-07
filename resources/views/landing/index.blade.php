@extends('landing.layouts.index')
@section('title', 'Beranda | Dangau Studio')
@section('menuBeranda','active')
@section('content')

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

{{-- TentangDangau --}}
<section>
    <div class="container-fluid tentang-kami">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold ">TENTANG <span class="text-success fs-7 mb-3 fw-bold">KAMI</span></h2>
            <div class="row flex-wrap-reverse">
                <div class="col-lg-5 col-md-12 text-lg-start">
                    <p class="text-dark mb-4">Dangau Studio adalah sebuah komunitas seni yang berlokasi di Jl. Simpang Akhirat, Kec. Kuranji, Kota Padang, Sumatra Barat. Sejak didirikan pada tahun 2015, komunitas ini telah berkomitmen untuk menjadi wadah bagi para seniman dan pecinta seni dalam menjelajahi berbagai ekspresi kreatif. Dengan berbagai program yang dirancang untuk meningkatkan apresiasi seni, Dangau Studio telah berhasil menarik perhatian masyarakat luas, khususnya kalangan muda yang kini semakin antusias untuk terlibat dalam kegiatan seni.</p>
                    <p class="text-dark mb-4">Salah satu program unggulan yang diinisiasi oleh Dangau Studio adalah Art Therapy, yang bertujuan untuk meningkatkan minat kawula muda terhadap seni sekaligus memberikan mereka ruang untuk mengekspresikan diri. Melalui pendekatan ini, peserta tidak hanya belajar tentang teknik seni, tetapi juga menemukan cara untuk menyalurkan emosi dan pengalaman hidup mereka. Dengan dukungan berbagai kegiatan dan workshop, Dangau Studio terus berupaya untuk memperkaya budaya seni di daerahnya dan menciptakan lingkungan yang inspiratif bagi generasi mendatang.
                    </p>
                </div>
                <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                    <img src="{{ asset('assets/img/tentang.png') }}" class="img-fluid rounded-4" alt="background">
                </div>
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
                    <div class="card h-100">
                        @if ($seniman->foto_profile)
                            <img class="card-img-top" src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="{{ $seniman->name }}" style="height: 300px; object-fit: contain;">
                        @else
                            <img src="{{ asset('assets/img/foto-profile.png') }}" alt="{{ $seniman->name }}" style="height: 300px; object-fit: contain;">
                        @endif
                        <div class="position-relative d-flex justify-content-center" style="margin-top: -19px;">
                            <a class="btn btn-square mx-1 rounded-5" href="{{ $seniman->medsos }}">
                                <i class="fab fa-instagram"></i> {{ $seniman->medsos_name }}
                            </a>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="mb-3">{{ $seniman->name }}</h5>
                            <small class="mb-3">{!! Str::limit(strip_tags($seniman->bio), 100) !!}</small>
                            <a href="/seniman/{{ $seniman->slug }}" class="btn btn-success">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <span class="text-muted">Belum ada</span>
                @endforelse
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
                            <h4 class="card-title">{{ $karya->name }}</h4>
                            <h5 class="card-text" style="color: #C62E2E;">Rp {{ number_format($karya->price, 0, ',', '.') }}</h5>
                            <p class="card-text fw-bold">Karya : {{ $karya->seniman->name }}</p>
                            <p class="card-text">{{ Str::limit(strip_tags($karya->deskripsi), 100) }}</p>
                            <a href="/galery/{{ $karya->slug }}" class="btn btn-success">
                                Lihat Detail
                            </a>
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

{{-- PameranDangau --}}
<section>
    <div class="container-fluid pameran">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">PAMERAN <span class="text-success fs-7 mb-3 fw-bold">SENI</span></h2>
            <div class="owl-carousel card-carousel position-relative">
                @forelse ($pamerans as $pameran)
                <div class="card-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $pameran->image) }}" alt="{{ $pameran->name }}" style="height: 300px; object-fit: contain;">
                        <div class="card-body ">
                            <h4 class="card-title">{{ $pameran->name_pameran }}</h4>
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
        </div>
    </div>
</section>

{{-- EventDangau --}}
<section>
    <div class="container-fluid event">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">EVENT <span class="text-success fs-7 mb-3 fw-bold">SENI</span></h2>
            <div class="owl-carousel card-carousel position-relative">
                @forelse ($events as $event)
                <div class="card-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->name }}" style="height: 300px; object-fit: contain;">
                        <div class="card-body">
                            <h4 class="card-title">{{ Str::limit($event->nama_event, 30) }}</h4>
                            <p class="card-text fw-bold">Insert : {{ $event->category }}</p>
                            <p class="card-text">{{ Str::limit(strip_tags($event->description), 100) }}</p>
                            <a href="/event/{{ $event->slug }}" class="btn btn-success">
                                Lihat Detail
                            </a>
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

{{-- BeritaDangau --}}
<section>
    <div class="container-fluid berita">
        <div class="container">
            <h2 class="text-dark mb-5 fw-bold text-center">BERITA <span class="text-success fs-7 mb-3 fw-bold">MENARIK</span></h2>
            <div class="owl-carousel card-carousel position-relative">
                @forelse ($beritas as $berita)
                <div class="card-item">
                    <div class="card">
                        <img class="card-img-top" src="{{ asset('storage/' . $berita->image) }}" alt="{{ $berita->name }}" style="height: 300px; object-fit: cover;">
                        <div class="card-body ">
                            <h4 class="card-title">{{ Str::limit(($berita->name), 50) }}</h4>
                            <p class="card-text text-end">{{ \Carbon\Carbon::parse($berita->tgl)->format('d F Y') }}</p>
                            <p class="card-text">{{ Str::limit(strip_tags($berita->description), 100) }}</p>
                            <a href="/berita/{{ $berita->slug }}" class="btn btn-success">
                                Lihat Detail
                            </a>
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

@endsection
