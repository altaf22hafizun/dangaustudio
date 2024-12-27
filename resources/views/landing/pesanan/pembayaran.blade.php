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

                <!-- Checkout Button -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-success w-100" id="pay-button">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('custom-script')
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                window.location.href = '/user/riwayat-pesanan';
                console.log(result);
                // alert("payment success!"); console.log(result);
            },
             onPending: function(result) {
                window.location.href = '/user/riwayat-pesanan';
                console.log(result);
            },
            onError: function(result) {
                // window.location.reload();
                // console.log(result);
                window.location.href = '/user/riwayat-pesanan';
                console.log(result);
            },
            onClose: function() {
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
            // onPending: function (result) {
            //     alert("waiting for your payment!"); console.log(result);
            // },
            // onError: function (result) {
            //     alert("payment failed!"); console.log(result);
            // },
            // onClose: function () {
            //     alert('you closed the popup without finishing the payment');
            // }
        });
    });
</script>
@endpush
