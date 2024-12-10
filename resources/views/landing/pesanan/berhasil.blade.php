@extends('landing.layouts.index')

@section('title', 'Pesanan Berhasil | Dangau Studio')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Pesanan Berhasil</h2>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-success text-white">
                <h4 class="text-light">Ringkasan Pesanan</h4>
            </div>
            <div class="card-body">
                <h5>Detail Pesanan Anda</h5>

                <div class="list-group">
                    @foreach($detailPesanan as $detail)
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{ Storage::url($detail->pesanan->karya->image) }}" alt="Karya" class="img-fluid rounded">
                            </div>
                            <div class="col-md-8">
                                <h5>{{ $detail->pesanan->karya->name }}</h5>
                                <p class="text-muted">Seniman: <strong>{{ $detail->pesanan->karya->seniman->name }}</strong></p>
                                <p class="text-danger fw-bold">Rp {{ number_format($detail->pesanan->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <h5>Informasi Pengiriman</h5>
                    <p><strong>Metode Pengiriman:</strong> {{ ucfirst($metode_pengiriman) }}</p>

                    @if($metode_pengiriman == 'Diantarkan')
                    <p><strong>Alamat Pengiriman:</strong> {{ $alamat }}</p>
                    @endif
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <h5>Total Harga</h5>
                    <p class="text-danger fw-bold">
                        Rp {{ number_format($total_harga, 0, ',', '.') }}
                    </p>
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary w-100">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
