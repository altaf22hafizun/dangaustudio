@extends('admin.layouts.index')
@section('title', 'Karya | Admin Dangau Studio')
@section('menuKarya','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="nav d-flex flex-column flex-md-row mb-3 align-items-md-center">
            <h5 class="mb-3 fw-bold me-md-auto">Karya</h5>
            <a
                href="{{ route('karya.create') }}"
                class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                role="button"
            >
                <i class="ti ti-plus fs-7 me-2"></i>
                Tambah Karya
            </a>
            {{-- <div class="nav d-flex flex-column flex-md-row align-items-md-center">
                <form class="d-flex mb-3" role="search" method="GET" action="{{ route('karya.index') }}">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit">Cari</button>
                </form>
            </div> --}}
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Gambar Karya</th>
                    <th scope="col" class=" text-light">Nama Seniman</th>
                    <th scope="col" class=" text-light">Nama Karya</th>
                    <th scope="col" class=" text-light">Harga</th>
                    <th scope="col" class=" text-light">Stock</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $karyas as $karya )
                    <tr>
                        <td>
                            @if ($karya->image)
                                <img src="{{ asset('storage/' . $karya->image) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $karya->seniman->name }}</td>
                        <td>{{ Str::limit($karya->name, 15) }}</td>
                        <td>Rp {{ number_format($karya->price, 0, ',', '.') }}</td>
                        <td>
                            @if ($karya->stock == 'Tersedia')
                                <span class="badge bg-light-success rounded-pill text-success px-3 py-2 fs-3">Tersedia</span>
                            @else
                                <span class="badge bg-light-danger rounded-pill text-danger px-3 py-2 fs-3">Terjual</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('karya.edit', $karya->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('karya.destroy', $karya->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data karya</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $karyas->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
