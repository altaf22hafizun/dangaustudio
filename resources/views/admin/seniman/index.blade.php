@extends('admin.layouts.index')
@section('title', 'Seniman | Admin Dangau Studio')
@section('menuSeniman','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Seniman</h5>
            <a
            href="{{ route('seniman.create') }}"
            class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-2"
            role="button"
            >
            <i class="ti ti-plus fs-7 me-2"></i>
            Tambah Seniman
            </a>
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Foto Seniman</th>
                    <th scope="col">Nama Seniman</th>
                    <th scope="col">Bio Seniman</th>
                    <th scope="col">Telepon</th>
                    <th scope="col">Instagram</th>
                    <th scope="col">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $senimans as $seniman )
                    <tr>
                        <td>
                            @if ($seniman->foto_profile)
                                <img src="{{ asset('storage/' . $seniman->foto_profile) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $seniman->name }}</td>
                        <td>{{ Str::limit($seniman->bio, 15) }}</td>
                        <td>{{ $seniman->telp }}</td>
                        <td><a href="{{ $seniman->medsos }}" target="_blank">@ {{ $seniman->medsos_name }}</a></td>
                        <td>
                            <a href="{{ route('seniman.edit', $seniman->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('seniman.destroy', $seniman->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
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
            {{ $senimans->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
