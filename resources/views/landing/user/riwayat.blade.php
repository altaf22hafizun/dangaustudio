@extends('landing.layouts.index')

@section('title', 'Riwayat Pesanan | Dangau Studio')

@section('content')

{{-- Riwayat Pesanan --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Riwayat Pesanan</h2>

        {{-- Navbar Riwayat Pesanan --}}
        <ul class="nav nav-tabs mb-4 d-flex flex-column flex-md-row align-items-md-center">
            <!-- Semua pesanan, menampilkan semua status -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === null ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan') }}">Semua</a>
            </li>
            <!-- Belum Bayar -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === '6' ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan?type=6') }}">Belum Bayar</a>
            </li>
            <!-- Dikemas -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === '4' ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan?type=4') }}">Dikemas</a>
            </li>
            <!-- Dikirim -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === '7' ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan?type=7') }}">Dikirim</a>
            </li>
            <!-- Selesai -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === '2' ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan?type=2') }}">Selesai</a>
            </li>
            <!-- Dibatalkan -->
            <li class="nav-item">
                <a class="nav-link {{ request('type') === '9' ? 'active text-light bg-success border border-dark rounded-pill' : '' }}" href="{{ url('/user/riwayat-pesanan?type=9') }}">Dibatalkan</a>
            </li>
        </ul>

        {{-- Pencarian Pesanan --}}
        <div class="mb-4">
            <form class="d-flex flex-column flex-md-row align-items-md-center" role="search" method="GET" action="{{ route('pesanan.riwayat') }}">
                <!-- Input Pencarian -->
                <div class="input-group mb-3 mb-md-0 me-md-3 flex-grow-1">
                    <input type="text" class="form-control border-3 shadow-sm" placeholder="Cari berdasarkan No. Pesanan atau Nama Produk" name="search" value="{{ request('search') }}">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <!-- Tombol Cari -->
                <button class="btn btn-success shadow-sm" type="submit">Cari</button>
            </form>
        </div>

        {{-- Tampilkan Pesanan --}}
        @forelse ($pesanan as $p)
            <div class="card mb-4 shadow-sm border-light rounded-lg">
                <div class="card-body">
                    <div class="d-flex justify-content-between flex-column flex-md-row align-items-md-center">
                        <h5 class="fw-bold text-success">Pesanan ID : {{ $p->trx_id }}</h5>
                        <p class="text-light btn btn-danger rounded-3 ms-2">
                            @switch($p->status_pembayaran)
                                @case('Menunggu Pembayaran dan Pengiriman')
                                    Menunggu Pembayaran
                                    @break
                                @case('Pengiriman Berhasil, Pembayaran Lunas')
                                    Selesai
                                    @break
                                @case('Pembayaran Diterima, Sedang Diproses untuk Pengiriman')
                                    Dikemas
                                    @break
                                @case('Pengiriman Dan Pembayaran Dibatalkan')
                                    Dibatalkan
                                    @break
                                @case('Paket Dalam Perjalanan')
                                    Dikirim
                                    @break
                            @endswitch
                        </p>
                    </div>
                    <div class="list-group">
                        @foreach ($p->detailPesanans as $detail)
                            <div class="list-group-item d-flex align-items-center p-3 mb-3 shadow-sm bg-light rounded">
                                <img
                                    src="{{ asset($detail->karya->image ? Storage::url($detail->karya->image) : 'path/to/default-image.jpg') }}"
                                    alt="Product Image"
                                    class="img-thumbnail me-3"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark">{{ $detail->karya->name }}</h6>
                                    <p class="text-muted mb-1">Seniman: {{ $detail->karya->seniman->name }}</p>
                                </div>
                                <div class="text-end">
                                    <p class="text-danger fw-bold">Rp {{ number_format($detail->price_karya, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center border-top border-3">
                    <span class="fw-bold mb-3 mb-md-0">
                        Total Pesanan: <span class="text-danger">Rp {{ number_format($p->price_total, 0, ',', '.') }}</span>
                    </span>
                    <div class="d-flex">
                        @if ($p->status_pembayaran == 'Menunggu Pembayaran dan Pengiriman')
                        <a href="{{ route('pesanan.pembayaran') }}" class="btn btn-success me-2 rounded-pill">Lihat Detail</a>
                        @else
                        <a href="{{ route('pesanan.detail', ['id' => $p->id]) }}" class="btn btn-success me-2 rounded-pill">Lihat Detail</a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="card mb-4 shadow-sm border-light rounded-lg">
                <div class="card-body">
                    <h5 class="fw-bold text-success text-center">Pesanan Tidak Ditemukan</h5>
                </div>
            </div>
        @endforelse
    </div>
</section>

@endsection
