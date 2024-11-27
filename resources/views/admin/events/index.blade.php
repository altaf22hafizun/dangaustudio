@extends('admin.layouts.index')
@section('title', 'Event | Admin Dangau Studio')
@section('menuEvent','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="nav d-flex flex-column flex-md-row mb-3 align-items-md-center">
            <h5 class="mb-3 fw-bold me-md-auto">Event</h5>
            <a
                href="{{ route('events.create') }}"
                class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-3 mb-3"
                role="button"
            >
                <i class="ti ti-plus fs-7 me-2"></i>
                Tambah Event
            </a>
            {{-- <div class="nav d-flex  flex-column flex-md-row align-items-md-center">
                {{-- <form class="d-flex mb-3" role="search" method="GET" action="{{ route('events.index') }}">
                    <input class="form-control me-2 shadow-sm" type="search" placeholder="Cari" aria-label="Search" name="search" value="{{ request('search') }}">
                    <button class="btn btn-success" type="submit">Cari</button>
                </form> 
            </div> --}}
        </div>


        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Gambar Event</th>
                    <th scope="col" class=" text-light">Nama Event</th>
                    <th scope="col" class=" text-light">Lokasi Event</th>
                    <th scope="col" class=" text-light">Tanggal Mulai Event</th>
                    <th scope="col" class=" text-light">Tanggal Berakhir Event</th>
                    <th scope="col" class=" text-light">Status</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $events as $event )
                    <tr>
                        <td>
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($event->nama_event, 15) }}</td>
                        <td>{!! Str::limit(strip_tags($event->location), 15) !!}</td>
                        <td>{{ $event->start_date }}</td>
                        <td>{{ $event->end_date }}</td>
                        <td>
                            @if ($event->status_publikasi == 'Published')
                                <span class="badge bg-light-success rounded-pill text-success px-3 py-2 fs-3">Aktif</span>
                            @else
                                <span class="badge bg-light-danger rounded-pill text-danger px-3 py-2 fs-3">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('events.edit', $event->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('events.destroy', $event->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data event</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $events->links() }}
        </div>
        </div>
    </div>
</div>


@endsection
