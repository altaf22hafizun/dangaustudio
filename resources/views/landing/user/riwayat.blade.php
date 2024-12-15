@extends('landing.layouts.index')
@section('title', 'Riwayat Pesanan | Dangau Studio')
@section('content')

{{-- Riwayat Pesanan --}}
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success text-center">Riwayat Pesanan</h2>

        {{-- Tab Menu --}}
        <ul class="nav nav-tabs mb-4 d-flex flex-column flex-md-row align-items-md-center">
            <li class="nav-item">
                <a class="nav-link active text-light bg-success border border-dark" href="#">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Belum Bayar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Sedang Dikirim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Dikirim</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Selesai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Dibatalkan</a>
            </li>
        </ul>

        {{-- Search Bar --}}
        <div class="input-group mb-4">
            <input type="text" class="form-control border-3" placeholder="Cari berdasarkan No. Pesanan atau Nama Produk">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>

        {{-- Pesanan Item --}}
        @foreach ($detailPesanan as $detail)
        <div class="card mb-4 shadow">
            <div class="card-body d-flex">
                <img
                    src="{{ asset($detail->karya->image ? Storage::url($detail->karya->image) : 'path/to/default-image.jpg') }}"
                    alt="Product Image"
                    class="img-thumbnail me-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <div class="flex-grow-1">
                    <h6 class="fw-bold">{{ $detail->karya->name }}</h6>
                    <p class="text-muted mb-1">Seniman: {{ $detail->karya->seniman->name }}</p>
                </div>
                <div class="text-end">
                    <p class="text-danger fw-bold">Rp {{ number_format($detail->price_karya, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center border-top border-3">
                <span class="fw-bold mb-3 mb-md-0">
                    Total Pesanan: <span class="text-danger">Rp {{ number_format($detail->price_karya, 0, ',', '.') }}</span>
                </span>
                <div class="d-flex">
                    <button class="btn btn-success me-2">Lihat Detail</button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

@endsection
