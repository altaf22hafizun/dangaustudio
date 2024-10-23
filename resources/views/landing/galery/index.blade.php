 @extends('landing.layouts.index')
 @section('title', 'Galery | Dangau Studio')
 @section('menuGalery', 'active')
 @section('content')

 {{-- KaryaDangau --}}
 <section>
    <div class="container mt-5 px-4">
         <div class="row mb-5">
             <div class="col-lg d-flex justify-content-between align-items-center">
                 <h2 class="mb-0 text-success">Galery Dangau Studio</h2>
                 {{-- <a class="btn btn-link fw-semibold text-decoration-none text-end" href="#">Lihat Semua</a> --}}
             </div>
         </div>
         <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4">
             @forelse ($karyas as $karya)
                 <div class="col mb-4">
                    <div class="card-item h-100">
                        <div class="card h-100 d-flex flex-column">
                            <img class="card-img-top" src="{{ Storage::url($karya->image) }}" alt="{{ $karya->name }}" style="object-fit: contain; height: 200px;" />
                            <div class="card-body d-flex flex-column flex-grow-1">
                                <h5 class="card-title">{!! Str::limit(strip_tags($karya->name), 30) !!}</h5>
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
