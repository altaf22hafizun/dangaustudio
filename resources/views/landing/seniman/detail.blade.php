@extends('landing.layouts.index')
@section('title', 'Detail Seniman | Dangau Studio')
@section('menuSeniman','active')
@section('content')

{{-- Detail Seniman --}}
<section>
    <div class="container mt-5 px-4">
            <div class="row flex-wrap-reverse mb-5">
                <div class="col-lg-6 col-md-12 text-lg-start">
                    <h2 class="text-success mb-3 fw-bold">Detail Seniman</h2>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Nama Seniman</td>
                                <td class="fw-bold">{{ $senimans->name }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>
                                    @if ($senimans->telp)
                                        {{ $senimans->telp }}
                                    @else
                                        <span class="text-muted">Tidak Ada</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Instagram</td>
                                <td>@ {{ $senimans->medsos_name }}</td>
                            </tr>
                            <tr>
                                <td>Bio</td>
                                <td>{!! strip_tags($senimans->bio) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                    <img src="{{ asset('storage/' . $senimans->foto_profile) }}" class="img-fluid rounded-4" style="height: 300px; object-fit: contain;" alt="Foto {{ $senimans->name }}">
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg d-flex justify-content-between align-items-center">
                    <h3 class="mb-0 text-success">Seniman Dangau Studio</h3>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-lg-4 justify-content-center">
                @forelse ($karyas as $karya)
                    <div class="col mb-4">
                        <div class="card-item h-100">
                            <div class="card h-100 d-flex flex-column">
                                <img class="card-img-top" src="{{ Storage::url($karya->image) }}" alt="{{ $karya->name }}" style="object-fit: cover; height: 300px;" />
                                <div class="card-body d-flex flex-column flex-grow-1">
                                    <h5 class="card-title">{!! Str::limit(strip_tags($karya->name), 30) !!}</h5>
                                    <small class="card-text mb-3">{!! Str::limit(strip_tags($karya->deskripsi), 50) !!}</small>
                                    <a href="/galery/{{ $karya->slug }}" class="btn btn-success mt-auto">
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
            <div class="d-flex justify-content-center mt-4 ">
                {{ $karyas->links() }}
            </div>
            <a href="/seniman" class="btn btn-success mt-5"><i class="fa-solid fa-angle-left me-2"></i>Kembali</a>
        </div>
    </div>
</section>

@endsection
