@extends('landing.layouts.index')
@section('title', 'Detail Seniman | Dangau Studio')
@section('menuSeniman','active')
@section('content')

{{-- Detail Seniman --}}
<section>
    <div class="container-fluid seniman">
        <div class="container">

            <div class="row flex-wrap-reverse mb-5">
                <div class="col-lg-6 col-md-12 text-lg-start">
                    <h2 class="text-dark mb-3 fw-bold">DETAIL <span class="text-success fs-7 mb-3 fw-bold">SENIMAN</span></h2>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Nama Seniman</td>
                                <td class="fw-bold">{{ $seniman->name }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>
                                    @if ($seniman->telp)
                                        {{ $seniman->telp }}
                                    @else
                                        <span class="text-muted">Tidak Ada</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Instagram</td>
                                <td>@ {{ $seniman->medsos_name }}</td>
                            </tr>
                            <tr>
                                <td>Bio</td>
                                <td>{!! strip_tags($seniman->bio) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-6 col-md-12 text-center mb-5 ms-auto">
                    <img src="{{ asset('storage/' . $seniman->foto_profile) }}" class="img-fluid rounded-4" style="height: 300px; object-fit: contain;" alt="Foto {{ $seniman->name }}">
                </div>
            </div>

            <h2 class="text-dark mb-5 fw-bold">KARYA <span class="text-success fs-7 mb-3 fw-bold">SENIMAN</span></h2>
            <div class="row">
                @forelse ($karyas as $karya)
                    <div class="col-12 col-sm-6 col-md-4 mb-4">
                        <div class="card-item">
                            <div class="card h-100">
                                <img class="card-img-top" src="{{ asset('storage/' . $karya->image) }}" alt="{{ $karya->name }}" style="height: 300px; object-fit: contain;">
                                <div class="card-body text-center">
                                    <h5 class="mb-3">{{ $karya->name }}</h5>
                                    <small class="mb-3">{!! Str::limit(strip_tags($karya->deskripsi), 100) !!}</small>
                                    <a href="admin/karya/{{ $karya->slug }}" class="btn btn-success">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center w-100">
                        <p class="text-muted fw-bolder">Belum ada karya yang dimiliki</p>
                    </div>
                @endforelse
            </div>

            <div class="d-flex justify-content-center mt-4 ">
                {{ $karyas->links() }} {{-- Paginasi untuk karya seniman --}}
            </div>
            <a href="/seniman" class="btn btn-success mt-5"><i class="fa-solid fa-angle-left me-2"></i>Kembali</a>
        </div>
    </div>
</section>

@endsection
