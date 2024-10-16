@extends('admin.layouts.index')
@section('title', 'Dashboard | Admin Dangau Studio')
@section('menuDashboard','active')
@section('content')

<div class="row">
    <!-- Card Seniman -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">Seniman</h5>
                    <span class="badge bg-light fs-3 text-dark fw-bold">{{ $senimanCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Karya Seni -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">Karya Seni</h5>
                    <span class="badge bg-light fs-3 text-dark fw-bold">{{ $karyaSeniCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pameran -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">Pameran</h5>
                    <span class="badge bg-light fs-3 text-dark fw-bold">{{ $eventCount }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Card User -->
    <div class="col-md-3 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">User</h5>
                    <span class="badge bg-light fs-3 text-dark fw-bold">{{ $userCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <!-- Card Grafik -->
    <div class="col-md-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header p-4">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold">Grafik</h5>
                </div>
            </div>
            <div class="card-body d-flex justify-content-center">
                <small>Belum ada grafik</small>
            </div>
        </div>
    </div>
    {{-- <!-- Card Grafik -->
    <div class="col-md-8 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">Grafik</h5>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Card Karya Seni -->
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-header p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Event Mendatang</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <ul class="list-group ">
                    @forelse ($upcomingEvents as $event)
                        <li class="list-group-item d-flex justify-content-between bg-success align-items-center rounded-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="text-light">{{ \Carbon\Carbon::parse($event->start_date)->format('d-M-Y') }}</span>
                                </div>
                                <div class="vr me-3" style="border-left: 5px solid #fff; height: auto;"></div>
                                <div class="mt-3">
                                    <h6 class="fw-bold text-light">{{ $event->nama_event }}</h6>
                                    <p class="text-light fst-italic">{!! Str::limit(strip_tags($event->location), 15) !!}</p>
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

    {{-- <!-- Card Karya Seni -->
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100 bg-success">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-light">Event Mendatang</h5>
                </div>
                <ul class="list-group ">
                    @forelse ($upcomingEvents as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-center rounded-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="text-dark">{{ \Carbon\Carbon::parse($event->start_date)->format('d-M-Y') }}</span>
                                </div>
                                <div class="vr me-3" style="border-left: 5px solid #000; height: auto;"></div>
                                <div class="mt-3">
                                    <h6 class="fw-bold text-dark">{{ $event->nama_event }}</h6>
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
    </div> --}}

    {{-- <!-- Card Karya Seni -->
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="d-flex mb-4 justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Event Mendatang</h5>
                </div>
                <ul class="list-group ">
                    @forelse ($upcomingEvents as $event)
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-success rounded-3">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <span class="text-light">{{ \Carbon\Carbon::parse($event->start_date)->format('d-M-Y') }}</span>
                                </div>
                                <div class="mt-3">
                                    <h6 class="fw-bold text-light">{{ $event->nama_event }}</h6>
                                    <p class="text-light fst-italic">{{ $event->location }}</p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>Saat ini tidak ada event yang dijadwalkan.</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div> --}}
</div>

@endsection
