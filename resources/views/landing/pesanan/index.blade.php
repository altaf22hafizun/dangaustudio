@extends('landing.layouts.index')
@section('title', 'Detail Pesanan | Dangau Studio')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Detail Pesanan</h2>
        <!-- Form Checkout -->
        <form action="/checkout" method="POST" enctype="multipart/form-data">
        @csrf
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

                    <!-- Metode Pengiriman -->
                    <div class="border p-3 my-3 shadow-sm">
                        <h5 class="text-success">Metode Pengiriman</h5>
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="shipping_method_pickup" name="metode_pengiriman" value="Dijemput">
                                <label for="shipping_method_pickup" class="form-check-label">Dijemput</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="shipping_method_delivery" name="metode_pengiriman" value="Diantarkan">
                                <label for="shipping_method_delivery" class="form-check-label">Diantarkan</label>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="border p-3 my-3 shadow-sm" id="alamat-container" style="display: none;">
                        <h5 class="text-success">
                            <i class="fas fa-map-marker-alt me-2"></i> Alamat Pengiriman
                        </h5>
                        <div class="mt-3">
                            <textarea class="form-control" id="address" name="address" rows="3" placeholder="Masukan Alamat Pengiriman">{{ Auth::user()->alamat ?? '' }}</textarea>
                        </div>
                        <div class="mt-3">
                            <label for="destination" class="form-label">Kota</label>
                            <select name="destination" id="destination" class="form-control">
                                <option value="">Pilih Tujuan Kota</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['city_id'] }}" data-province-id="{{ $city['province_id'] }}" data-province="{{ $city['province'] }}">
                                        {{ $city['city_name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-3">
                            <label for="province" class="form-label">Provinsi</label>
                            <input type="text" name="province" id="province" class="form-control" readonly placeholder="Provinsi"/>
                        </div>
                        <!-- Mengganti full_address menjadi alamat -->
                        <input type="hidden" name="alamat" id="alamat"/>
                        <!-- Kota Awal -->
                        <input type="hidden" id="origin" name="origin" class="form-control" value="{{ $cityPadang['city_name'] }}" disabled readonly/>
                        <!-- Berat Paket -->
                        <input type="hidden" id="weight" name="weight" class="form-control" value="1000" disabled readonly/>
                    </div>

                    <!-- Delivery Service -->
                    <div class="border p-3 my-3 shadow-sm" id="delivery" style="display: none;">
                        <h5 class="text-success">
                            <i class="fas fa-truck me-2"></i> Delivery Service
                        </h5>
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input courier-code" id="jne" name="courier_code" value="jne">
                                <label for="jne" class="form-check-label">JNE</label>
                            </div>
                        </div>
                        <div class="mt-3" id="jne-options" style="display: none;">
                            <label for="jne-service" class="form-label">Pilih Jenis Pengiriman</label>
                            <select name="jne_service" id="jne-service" class="form-control">
                                <option value="">Pilih Layanan</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                        <div class="mt-3" id="jne-cost" style="display: none;">
                            <span>Biaya Pengiriman: </span>
                            <span id="jne-fee">Rp 0</span>
                            <div>Estimasi: <span id="jne-estimation">-</span> Hari</div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pembayaran dan Form Checkout -->
                <div class="col-lg-4">
                    <div class="border p-3 shadow-sm">
                        <h5 class="text-success mb-3">Ringkasan Pembayaran</h5>
                        <div class="d-flex justify-content-between">
                            <span>Total Item:</span>
                            <span>{{ count($pesanans) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>SubTotal:</span>
                            <span id="total-price">Rp {{ number_format($pesanans->sum('price'), 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2" id="shipping-container" style="display: none;">
                            <span>Ongkos Kirim:</span>
                            <span id="shipping-fee">Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span><strong>Grand Total:</strong></span>
                            <span id="grand-total">Rp {{ number_format($pesanans->sum('price'), 0, ',', '.') }}</span>
                        </div>
                        <!-- Submit -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100">Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('custom-script')
<script>
 document.addEventListener('DOMContentLoaded', function() {
    const destinationSelect = document.getElementById('destination');
    const provinceInput = document.getElementById('province');
    const alamatTextarea = document.getElementById('address');
    const alamatInput = document.getElementById('alamat');
    const shippingMethodRadioButtons = document.querySelectorAll('input[name="metode_pengiriman"]');
    const alamatContainer = document.getElementById('alamat-container');
    const deliveryContainer = document.getElementById('delivery');
    const jneOptions = document.getElementById('jne-options');
    const jneServiceSelect = document.getElementById('jne-service');
    const jneCostContainer = document.getElementById('jne-cost');
    const jneFeeSpan = document.getElementById('jne-fee');
    const jneEstimationSpan = document.getElementById('jne-estimation');

    // Event listener untuk memilih kota tujuan
    destinationSelect.addEventListener('change', function() {
        const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
        const provinceName = selectedOption.getAttribute('data-province');
        provinceInput.value = provinceName || '';
    });

    // Event listener untuk mengisi alamat lengkap saat form dikirim
    document.querySelector('form').addEventListener('submit', function() {
        const alamat = `${alamatTextarea.value}, ${destinationSelect.options[destinationSelect.selectedIndex]?.text || ''}, ${provinceInput.value}`;
        alamatInput.value = alamat;
    });

    // Menyembunyikan atau menampilkan alamat dan layanan pengiriman berdasarkan metode pengiriman
    shippingMethodRadioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Diantarkan') {
                alamatContainer.style.display = 'block';
                deliveryContainer.style.display = 'block';
            } else {
                alamatContainer.style.display = 'none';
                deliveryContainer.style.display = 'none';
            }
        });
    });

    // Ketika kurir JNE dipilih, tampilkan opsi jenis layanan dan biaya
    jneServiceSelect.addEventListener('change', function() {
        if (this.value) {
            jneCostContainer.style.display = 'block';
            // Panggil API untuk mendapatkan ongkos kirim
            fetch('/cekongkir', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    origin: document.getElementById('origin').value,
                    destination: destinationSelect.value,
                    weight: document.getElementById('weight').value,
                    courier: 'jne'
                })
            })
            .then(response => response.json())
            .then(data => {
                const cost = data.rajaongkir.results[0].costs.find(c => c.service === this.value);
                jneFeeSpan.textContent = `Rp ${cost.cost[0].value.toLocaleString()}`;
                jneEstimationSpan.textContent = cost.cost[0].etd || '-';
            });
        }
    });

    // Tampilkan pilihan layanan pengiriman saat JNE dipilih
    document.getElementById('jne').addEventListener('change', function() {
        jneOptions.style.display = this.checked ? 'block' : 'none';
    });
});
</script>
@endpush

