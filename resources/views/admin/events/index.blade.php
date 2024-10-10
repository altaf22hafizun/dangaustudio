@extends('admin.layouts.index')
@section('title', 'Event | Admin Dangau Studio')
@section('menuEvent','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Event</h5>
            <a
            href="{{ route('events.create') }}"
            class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-2"
            role="button"
            >
            <i class="ti ti-plus fs-7 me-2"></i>
            Tambah Event
            </a>
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-dark text-center">
                <tr>
                    <th scope="col">Gambar Event</th>
                    <th scope="col">Nama Event</th>
                    <th scope="col">Lokasi Event</th>
                    <th scope="col">Tanggal Mulai Event</th>
                    <th scope="col">Tanggal Berakhir Event</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
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
                        <td>{{ $event->location }}</td>
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
