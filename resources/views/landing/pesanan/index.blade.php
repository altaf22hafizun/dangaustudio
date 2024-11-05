@extends('landing.layouts.index')
@section('title', 'Detail Pesanan | Dangau Studio')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Detail Pesanan</h2>
        <div class="row">
            <div class="col-lg-8">
                <div class="border p-3 shadow-sm">
                    @foreach ($pesanans as $pesanan)
                    <div class="border p-3 mb-3 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img src="{{ Storage::url($pesanan->karya->image) }}" alt="Karya" class="img-fluid rounded">
                            </div>
                            <div class="col-6">
                                <h5 class="text-dark">{{ $pesanan->karya->name }}</h5>
                                <p class="text-muted">Seniman: <strong>{{ $pesanan->karya->seniman->name }}</strong></p>
                                <p class="text-danger fw-bold">Rp {{ number_format($pesanan->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Pembayaran dan Form Checkout -->
            <div class="col-lg-4">
                <div class="border p-3 shadow-sm">
                    <h4 class="text-success">Ringkasan Pembayaran</h4>
                    <div class="d-flex justify-content-between">
                        <span>Total Item:</span>
                        <span>{{ count($pesanans) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>SubTotal:</span>
                        <span id="total-price">Rp {{ number_format($pesanans->sum('price'), 0, ',', '.') }}</span>
                    </div>

                    <!-- Total Pajak -->
                    <div class="d-flex justify-content-between mt-2" id="tax-container" style="display: none;">
                        <span>Pajak (5%):</span>
                        <span id="tax-amount">Rp 0</span>
                    </div>

                    <!-- Grand Total -->
                    <div class="d-flex justify-content-between mt-2">
                        <span><strong>Grand Total:</strong></span>
                        <span id="grand-total">Rp {{ number_format($pesanans->sum('price'), 0, ',', '.') }}</span>
                    </div>

                    <!-- Form Checkout -->
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="total_price" value="{{ $pesanans->sum('price') }}">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="pesanan_ids" value="{{ implode(',', $pesanans->pluck('id')->toArray()) }}">

                        <!-- Pilihan Pengiriman -->
                        <div class="mt-3">
                            <label for="shipping_method" class="form-label">Metode Pengiriman</label>
                            <select class="form-select" id="shipping_method" name="shipping_method" required>
                                <option value="" selected disabled>Pilih Metode Pengiriman</option>
                                <option value="pickup">Dapat Dijemput</option>
                                <option value="delivery">Diantarkan</option>
                            </select>
                        </div>

                        <!-- Alamat Pengiriman -->
                        <div class="mt-3" id="address-container" style="display: none;">
                            <label for="address" class="form-label">Alamat Pengiriman</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>

                        <!-- Upload Bukti Pembayaran -->
                        <div class="mt-3">
                            <label for="payment_proof" class="form-label">Bukti Pembayaran</label>
                            <input type="file" class="form-control" id="payment_proof" name="payment_proof" accept="image/*,application/pdf" required>
                            <small class="form-text text-muted">Upload bukti pembayaran berupa gambar atau PDF.</small>
                        </div>

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success w-100">Lanjutkan ke Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('custom-script')
<script>
    // Update harga, pajak, dan grand total berdasarkan pilihan pengiriman
    document.getElementById('shipping_method').addEventListener('change', function() {
        const shippingMethod = this.value;
        const totalPrice = {{ $pesanans->sum('price') }};
        const taxContainer = document.getElementById('tax-container');
        const taxAmount = document.getElementById('tax-amount');
        const addressContainer = document.getElementById('address-container');
        const grandTotalElement = document.getElementById('grand-total');

        if (shippingMethod === 'delivery') {
            // Tampilkan alamat dan pajak
            addressContainer.style.display = 'block';
            taxContainer.style.display = 'block';

            // Hitung pajak 5%
            const tax = totalPrice * 0.05;
            const grandTotal = totalPrice + tax;
            taxAmount.innerText = 'Rp ' + tax.toLocaleString('id-ID');
            grandTotalElement.innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        } else if (shippingMethod === 'pickup') {
            // Tampilkan pengambilan tanpa pajak
            addressContainer.style.display = 'none';
            taxContainer.style.display = 'none';
            grandTotalElement.innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
        }
    });
</script>
@endpush
