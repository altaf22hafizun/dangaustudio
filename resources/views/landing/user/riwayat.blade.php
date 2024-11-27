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
        <div class="card mb-4 shadow">
            <div class="card-body d-flex">
                <img
                    src="{{ asset('path/to/image.jpg') }}"
                    alt="Product Image"
                    class="img-thumbnail me-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <div class="flex-grow-1">
                    <h6 class="fw-bold">Bara</h6>
                    <p class="text-muted mb-1">Seniman: Diah Putranti Rahmaning</p>
                </div>
                <div class="text-end">
                    {{-- <p class="text-muted text-decoration-line-through mb-0">Rp55.000</p> --}}
                    <p class="text-danger fw-bold">Rp 5.000.000</p>
                </div>
            </div>
            <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center border-top border-3">
                <span class="fw-bold mb-3 mb-md-0">
                    Total Pesanan: <span class="text-danger">Rp 5.000.000</span>
                </span>
                <div class="d-flex">
                    <button class="btn btn-success me-2">Lihat Detail</button>
                </div>
            </div>
        </div>
        <div class="card mb-4 shadow">
            <div class="card-body d-flex">
                <img
                    src="{{ asset('path/to/image.jpg') }}"
                    alt="Product Image"
                    class="img-thumbnail me-3"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <div class="flex-grow-1">
                    <h6 class="fw-bold">Bara</h6>
                    <p class="text-muted mb-1">Seniman: Diah Putranti Rahmaning</p>
                </div>
                <div class="text-end">
                    {{-- <p class="text-muted text-decoration-line-through mb-0">Rp55.000</p> --}}
                    <p class="text-danger fw-bold">Rp 5.000.000</p>
                </div>
            </div>
            <div class="card-footer d-flex flex-column flex-md-row justify-content-between align-items-md-center border-top border-3">
                <span class="fw-bold mb-3 mb-md-0">
                    Total Pesanan: <span class="text-danger">Rp 5.000.000</span>
                </span>
                <div class="d-flex">
                    <button class="btn btn-success me-2">Lihat Detail</button>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
