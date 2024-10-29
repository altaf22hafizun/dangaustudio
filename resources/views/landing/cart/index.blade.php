@extends('landing.layouts.index')
@section('title', 'Keranjang | Dangau Studio')
@section('menuCart','active')
@section('content')

<div class="container mt-5">
    <h2 class="text-success mb-4">Keranjang Belanja</h2>
    <div class="row">
        <div class="col-lg-8">
            <div class="cart-item border p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Karya" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                        <h5 class="text-dark">Nama Karya</h5>
                        <p class="text-muted">Seniman: <strong>Nama Seniman</strong></p>
                        <p class="text-danger">Rp 1.000.000</p>
                    </div>
                    <div class="col-4 text-end">
                        <input type="number" class="form-control w-50 d-inline" value="1" min="1">
                        <button class="btn btn-danger ms-2">Hapus</button>
                    </div>
                </div>
            </div>

            <div class="cart-item border p-3 mb-3">
                <div class="row align-items-center">
                    <div class="col-2">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="Karya" class="img-fluid rounded">
                    </div>
                    <div class="col-6">
                        <h5 class="text-dark">Nama Karya 2</h5>
                        <p class="text-muted">Seniman: <strong>Nama Seniman 2</strong></p>
                        <p class="text-danger">Rp 500.000</p>
                    </div>
                    <div class="col-4 text-end">
                        <input type="number" class="form-control w-50 d-inline" value="1" min="1">
                        <button class="btn btn-danger ms-2">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="border p-3">
                <h4 class="text-success">Ringkasan Belanja</h4>
                <div class="d-flex justify-content-between">
                    <span>Total Item:</span>
                    <span>2</span>
                </div>
                <div class="d-flex justify-content-between mt-2">
                    <span>Total:</span>
                    <span>Rp 1.500.000</span>
                </div>
                <button class="btn btn-success w-100 mt-3">Lanjutkan ke Pembayaran</button>
            </div>
        </div>
    </div>
</div>

@endsection
