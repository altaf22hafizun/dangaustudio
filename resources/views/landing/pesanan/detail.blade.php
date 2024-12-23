@extends('landing.layouts.index')

@section('title', 'Ringkasan Pesanan| Dangau Studio')

@section('content')
<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Ringkasan Pesanan</h2>

        <div class="card shadow-sm mb-5">
            <div class="card-header bg-success text-white">
                <h4 class="text-light">Ringkasan Pesanan</h4>
            </div>
            <div class="card-body">
                <h5 class="mb-4">Detail Pesanan Anda</h5>
                <div class="list-group">
                    @foreach($pesanan->detailPesanans as $detail)
                    <div class="list-group-item d-flex align-items-center py-3">
                        <div class="row w-100">
                            <!-- Image column -->
                            <div class="col-md-2 mb-3">
                                @if ($detail->karya->image)
                                    <img src="{{ Storage::url($detail->karya->image) }}" alt="Karya" class="img-fluid rounded shadow-sm" style="height: 200px; width: 250px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/default-image.jpg') }}" alt="Karya" class="img-fluid rounded shadow-sm" style="height: 200px; width: 250px; object-fit: cover;">
                                @endif
                            </div>
                            <!-- Item details -->
                            <div class="col-md-10">
                                @if ($detail->karya_id)
                                    <h5>{{ $detail->karya->name }}</h5>
                                    <p class="text-muted">Seniman: <strong>{{ $detail->karya->seniman->name }}</strong></p>
                                @else
                                    <h5>Nama Karya Tidak Ditemukan</h5>
                                    <p class="text-muted">Seniman: <strong>Seniman Tidak Ditemukan</strong></p>
                                @endif
                                <p class="text-danger fw-bold">Rp {{ number_format($detail->price_karya, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Informasi Pengiriman -->
                @if ($pesanan)
                    <div class="mt-4">
                        <h5 class="mb-3">Informasi Pengiriman</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <p><strong>Pesanan ID:</strong></p>
                            <p class="fw-bold text-dark">{{ $pesanan->trx_id}}</p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p><strong>Status Pesanan:</strong></p>
                            <p class="fw-bold text-light btn
                            {{ $pesanan->status == 'Dikemas' ? 'btn-warning' : '' }}
                            {{ $pesanan->status == 'Selesai' ? 'btn-success' : '' }}
                            {{ $pesanan->status == 'Belum Bayar' ? 'btn-danger' : '' }}
                            {{ $pesanan->status == 'Dikirim' ? 'btn-primary' : '' }}
                            {{ $pesanan->status == 'Dibatalkan' ? 'btn-secondary' : '' }}
                        ">
                            @switch($pesanan->status)
                                @case('Dikemas')
                                    Pembayaran Diterima, Sedang Diproses untuk Pengiriman
                                    @break
                                @case('Selesai')
                                    Pengiriman Berhasil, Pembayaran Lunas
                                    @break
                                @case('Belum Bayar')
                                    Menunggu Pembayaran dan Pengiriman
                                    @break
                                @case('Dikirim')
                                    Paket Dalam Perjalanan
                                    @break
                                @case('Dibatalkan')
                                    Pengiriman Dan Pembayaran Dibatalkan
                                    @break
                            @endswitch
                        </p>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <p><strong>Resi Pengiriman:</strong></p>
                            <p>{{ $pesanan->resi_pengiriman ?? '-' }}</p>
                        </div>
                        @if($pesanan->metode_pengiriman == 'Diantarkan')
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Alamat Pengiriman:</strong></p>
                                <p>{{ $pesanan->alamat }}</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Kurir:</strong></p>
                                <p>JNE</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Metode Pengiriman:</strong></p>
                                <p>{{ $pesanan->metode_pengiriman }}</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Jenis Pengiriman:</strong></p>
                                <p>{{ $pesanan->jenis_pengiriman }}</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Ongkos Pengiriman:</strong></p>
                                <p>Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</p>
                            </div>
                        @else
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Alamat Pengiriman:</strong></p>
                                <p>-</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Kurir:</strong></p>
                                <p>-</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Metode Pengiriman:</strong></p>
                                <p>{{ $pesanan->metode_pengiriman }}</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Jenis Pengiriman:</strong></p>
                                <p>-</p>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <p><strong>Ongkos Pengiriman:</strong></p>
                                <p>Rp -</p>
                            </div>
                        @endif
                    </div>

                @endif

                <!-- Total Price -->
                <div class="mt-4 d-flex justify-content-between">
                    <h5>Total Harga</h5>
                    <p class="text-danger fw-bold">
                        Rp {{ number_format($pesanan->price_total, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Button -->
                <div class="mt-3">
                    <!-- Tombol Konfirmasi Selesai -->
                    @if ($pesanan->status == 'Dikirim')
                    <form action="{{ route('pesanan.konfirmasi', $pesanan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100 mb-3">Konfirmasi Selesai</button>
                    </form>
                    @endif
                    <!-- Tombol Kembali -->
                    <a href="{{ route('pesanan.riwayat') }}" class="btn btn-success w-100 ">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

