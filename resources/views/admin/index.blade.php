@extends('admin.layouts.index')
@section('title', 'Dashboard | Admin Dangau Studio')
@section('menuDashboard','active')
@section('content')

<div class="row">
    <!-- Card Seniman -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Seniman</h5>
                    <span class="badge bg-primary">{{ $senimanCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Karya Seni -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Karya Seni</h5>
                    <span class="badge bg-primary">{{ $karyaSeniCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pameran -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Pameran</h5>
                    <span class="badge bg-primary">{{ $eventCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card User -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">User</h5>
                    <span class="badge bg-primary">{{ $userCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <!-- Card Grafik -->
    <div class="col-md-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Grafik</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Karya Seni -->
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Event Mendatang</h5>
                </div>
                <ul class="list-group">
                    @forelse ($upcomingEvents as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="text-dark">{{ \Carbon\Carbon::parse($event->start_date)->format('d-M-Y') }}</span>
                                </div>
                                <div class="mt-3">
                                    <h6 class="fw-bold">{{ $event->nama_event }}</h6>
                                    <p class="text-dark fst-italic">{{ $event->location }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>Saat ini tidak ada event yang dijadwalkan.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection
