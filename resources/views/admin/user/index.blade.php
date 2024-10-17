@extends('admin.layouts.index')
@section('title', 'User | Admin Dangau Studio')
@section('menuUser','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-3 fw-bold mt-2">User</h5>
            {{-- <a
            href="{{ route('user.create') }}"
            class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-2"
            role="button"
            >
            <i class="ti ti-plus fs-7 me-2"></i>
            Tambah Pengguna
            </a> --}}
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Nama Pengguna</th>
                    <th scope="col" class=" text-light">Email Pengguna</th>
                    <th scope="col" class=" text-light">Email Verifikasi</th>
                    <th scope="col" class=" text-light">Telepon</th>
                    {{-- <th scope="col" class=" text-light">Aksi</th> --}}
                </tr>
                </thead>
                <tbody>
                    @forelse ( $users as $user )
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->email_verified_at)
                            <span class="btn btn-success">Verifikasi</span>
                            @else
                            <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->telp)
                            {{ $user->telp }}
                            @else
                            <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        {{-- <td>
                            <a href="{{ route('user.edit', $user->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('user.destroy', $user->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td> --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
