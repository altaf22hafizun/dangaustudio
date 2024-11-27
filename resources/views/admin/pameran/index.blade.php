@extends('admin.layouts.index')
@section('title', 'Pameran | Admin Dangau Studio')
@section('menuPameran','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="nav d-flex flex-column flex-md-row mb-3 align-items-md-center">
            <h5 class="mb-3 fw-bold me-md-auto">Pameran</h5>
            <a
                href="{{ route('pameran.create') }}"
                class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                role="button"
            >
                <i class="ti ti-plus fs-7 me-2"></i>
                Tambah Pameran
            </a>
            {{-- <div class="nav d-flex  flex-column flex-md-row align-items-md-center">
                <a
                    href="{{ route('pameran.create') }}"
                    class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                    role="button"
                >
                    <i class="ti ti-plus fs-7 me-2"></i>
                    Tambah Pameran
                </a>
                <form class="d-flex mb-3" role="search" method="GET" action="{{ route('pameran.index') }}">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit">Cari</button>
                </form>
            </div> --}}
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Gambar Pameran</th>
                    <th scope="col" class=" text-light">Nama Pameran</th>
                    <th scope="col" class=" text-light">Deskripsi Pameran</th>
                    <th scope="col" class=" text-light">Tanggal Mulai Pameran</th>
                    <th scope="col" class=" text-light">Tanggal Berakhir Pameran</th>
                    <th scope="col" class=" text-light">Status</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $pamerans as $pameran )
                    <tr>
                        <td>
                            @if ($pameran->image)
                                <img src="{{ asset('storage/' . $pameran->image) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($pameran->name_pameran, 15) }}</td>
                        <td>{!! Str::limit(strip_tags($pameran->description), 15) !!}</td>
                        <td>{{ $pameran->start_date }}</td>
                        <td>{{ $pameran->end_date }}</td>
                        <td>
                            @if ($pameran->status_publikasi == 'Published')
                                <span class="badge bg-light-success rounded-pill text-success px-3 py-2 fs-3">Aktif</span>
                            @else
                                <span class="badge bg-light-danger rounded-pill text-danger px-3 py-2 fs-3">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pameran.edit', $pameran->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('pameran.destroy', $pameran->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data pameran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $pamerans->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
