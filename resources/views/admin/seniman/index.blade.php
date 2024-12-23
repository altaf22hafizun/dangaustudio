@extends('admin.layouts.index')
@section('title', 'Seniman | Admin Dangau Studio')
@section('menuSeniman','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="nav d-flex flex-column flex-md-row mb-3 align-items-md-center">
            <h5 class="mb-3 fw-bold me-md-auto">Seniman</h5>
            <a
                href="{{ route('seniman.create') }}"
                class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                role="button"
            >
                <i class="ti ti-plus fs-7 me-2"></i>
                Tambah Seniman
            </a>
            {{-- <div class="nav d-flex  flex-column flex-md-row align-items-md-center">
                <a
                    href="{{ route('seniman.create') }}"
                    class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                    role="button"
                >
                    <i class="ti ti-plus fs-7 me-2"></i>
                    Tambah Seniman
                </a>
                <form class="d-flex mb-3" role="search" method="GET" action="{{ route('seniman.index') }}">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit">Cari</button>
                </form>
            </div> --}}
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Foto Seniman</th>
                    <th scope="col" class=" text-light">Nama Seniman</th>
                    <th scope="col" class=" text-light">Bio Seniman</th>
                    <th scope="col" class=" text-light">Telepon</th>
                    <th scope="col" class=" text-light">Instagram</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $senimans as $seniman )
                    <tr>
                        <td>
                            @if ($seniman->foto_profile)
                                <img src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <img src="{{ asset('assets/img/foto-profile.png') }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @endif
                        </td>
                        <td>{{ $seniman->name }}</td>
                        <td>{!! Str::limit(strip_tags($seniman->bio), 15) !!}</td>
                        <td>
                            @if ($seniman->telp)
                            {{ $seniman->telp }}
                            @else
                            <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td>@if ($seniman->medsos_name)
                            <a href="{{ $seniman->medsos }}" target="_blank">@ {{ $seniman->medsos_name }}</a>
                        @else
                            <span class="text-muted">Belum ada</span>
                        @endif</td>
                        <td>
                            <a href="{{ route('seniman.edit', $seniman->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('seniman.destroy', $seniman->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data seniman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $senimans->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
