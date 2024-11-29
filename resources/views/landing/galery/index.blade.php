 @extends('landing.layouts.index')
 @section('title', 'Galery | Dangau Studio')
 @section('menuGalery', 'active')
 @section('content')

{{-- KaryaDangau --}}
<section>
    <div class="container mt-5 px-4">
        <div class="nav d-flex flex-column flex-md-row mb-5 align-items-md-center">
            <h2 class="mb-3 me-md-auto text-success">Galery Dangau Studio</h2>
            <form class="d-flex mb-3" role="search" method="GET" action="{{ route('galery.landing') }}">
                <!-- Filter berdasarkan Medium -->
                <select class="form-control me-2 shadow-sm" name="medium" aria-label="Pilih Medium">
                    <option value="">Pilih Medium</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->medium }}" {{ request('medium') == $category->medium ? 'selected' : '' }}>
                            {{ $category->medium }}
                        </option>
                    @endforeach
                </select>

                <!-- Filter berdasarkan Tahun -->
                <select class="form-control me-2 shadow-sm" name="tahun" aria-label="Pilih Tahun">
                    <option value="">Pilih Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-success" type="submit">Cari</button>
            </form>
        </div>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
            @forelse ($karyas as $karya)
                <div class="col mb-4">
                    <div class="card-item h-100">
                        <div class="card h-100 d-flex flex-column">
                            <div class="position-relative">
                                <img class="card-img-top" src="{{ Storage::url($karya->image) }}" alt="{{ $karya->name }}" style="object-fit: cover; height: 200px;" />
                                @if ($karya->stock == "Terjual")
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2 rounded-5 py-2 px-3">Terjual</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column flex-grow-1">
                                <h5 class="card-title">{{ $karya->name }}</h5>
                                <small class="card-text mb-3">{!! Str::limit(strip_tags($karya->deskripsi), 50) !!}</small>
                                <a href="galery/{{ $karya->slug }}" class="btn btn-success mt-auto">
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
            {{ $karyas->links() }}
        </div>
    </div>
</section>

@endsection
