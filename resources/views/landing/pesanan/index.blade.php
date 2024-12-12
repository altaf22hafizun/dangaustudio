@extends('landing.layouts.index')
@section('title', 'Detail Pesanan | Dangau Studio')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Detail Pesanan</h2>
        <form action="/checkout" method="POST" enctype="multipart/form-data">
        @csrf

            <div class="row">
                <div class="col-lg-8">
                    <div class="border p-3 shadow-sm">
                        @foreach ($pesanans as $pesanan)
                        <!-- Kirimkan ID pesanan yang dipilih -->
                        <input type="hidden" name="pesanan_id[{{ $pesanan->id }}]" value="{{ $pesanan->id }}" />
                        <input type="hidden" id="shipping-service-input" name="jenis_pengiriman" value="">
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
                                <input type="radio" class="form-check-input" id="shipping_method_pickup" name="metode_pengiriman" value="Dijemput" {{ old('metode_pengiriman') == 'Dijemput' ? 'checked' : '' }} required>
                                <label for="shipping_method_pickup" class="form-check-label">Dijemput</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="shipping_method_delivery" name="metode_pengiriman" value="Diantarkan" {{ old('metode_pengiriman') == 'Diantarkan' ? 'checked' : '' }} required>
                                <label for="shipping_method_delivery" class="form-check-label">Diantarkan</label>
                            </div>
                        </div>
                        @error('metode_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Pengiriman -->
                    <div class="border p-3 my-3 shadow-sm" id="alamat-container" style="display: none;">
                        <h5 class="text-success">
                            <i class="fas fa-map-marker-alt me-2"></i> Alamat Pengiriman
                        </h5>
                        <div class="mt-3">
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukan Alamat Pengiriman" required>{{ old('alamat', Auth::user()->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="destination" class="form-label">Kota / Kabupaten</label>
                            <select name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror">
                                <option value="">Pilih Tujuan Kota / Kabupaten</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city['city_id'] }}" data-province-id="{{ $city['province_id'] }}" data-province="{{ $city['province'] }}" {{ old('destination') == $city['city_id'] ? 'selected' : '' }}>
                                        {{ $city['city_name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('destination')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mt-3">
                            <label for="province" class="form-label">Provinsi</label>
                            <input type="text" name="province" id="province" class="form-control @error('province') is-invalid @enderror" value="{{ old('province') }}" readonly placeholder="Provinsi"/>
                            @error('province')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" id="origin" name="origin" class="form-control" value="{{ $cityPadang['city_id'] }}" disabled readonly/>
                        <input type="hidden" id="weight" name="weight" class="form-control" value="1000" disabled readonly/>
                    </div>

                    <!-- Delivery Service -->
                    <div class="border p-3 my-3 shadow-sm" id="delivery" style="display: none;">
                        <h5 class="text-success">
                            <i class="fas fa-truck me-2"></i> Delivery Service
                        </h5>
                        <div class="mt-3">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="jne" name="courier" value="jne">
                                <label for="jne" class="form-check-label">JNE</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <p>Available Services:</p>
                            <div class="list-group list-group-flush available-services" style="display: none;"></div>
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
                        <div class="d-flex justify-content-between mt-2" id="shipping-container">
                            <span>Ongkos Kirim:</span>
                            <span id="shipping-fee">Rp 0</span>
                            <input type="hidden" name="shipping_fee" id="shipping-fee-input" value="0">
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span><strong>Grand Total:</strong></span>
                            <span id="grand-total">Rp {{ number_format($pesanans->sum('price'), 0, ',', '.') }}</span>
                        </div>
                        <!-- Submit -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success w-100" id="pay-button">Checkout</button>
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
    const apiKey = '{{ env("RAJAONGKIR_API_KEY") }}';
    const destinationSelect = document.getElementById('destination');
    const provinceInput = document.getElementById('province');
    const shippingMethodRadioButtons = document.querySelectorAll('input[name="metode_pengiriman"]');
    const alamatContainer = document.getElementById('alamat-container');
    const deliveryContainer = document.getElementById('delivery');
    const availableServicesContainer = document.querySelector('.available-services');
    const shippingFeeContainer = document.getElementById('shipping-fee');
    const grandTotalContainer = document.getElementById('grand-total');
    const totalPriceElement = document.getElementById('total-price');
    const addressInput = document.getElementById('address');  // Input alamat
    let shippingFee = 0;

    // Mengambil subtotal dari elemen text dan menghapus karakter yang tidak perlu
    let subTotalText = totalPriceElement.textContent.replace('Rp ', '').replace(/\./g, ''); // Menghapus 'Rp' dan titik (.)
    let subTotal = parseInt(subTotalText);  // Mengubah string menjadi angka

   // Fungsi untuk memperbarui data pengiriman
    function updateShippingServices(destinationId) {
        if (destinationId) {
            fetch("{{ route('getShippingServices') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'API_KEY': apiKey
                },
                body: JSON.stringify({
                    destination: destinationId,
                    courier: 'jne',
                    origin: document.getElementById('origin').value,
                    weight: document.getElementById('weight').value,
                })
            })
            .then(response => response.json())
            .then(data => {
                // Clear previous services
                availableServicesContainer.innerHTML = '';

                if (data && Array.isArray(data) && data.length > 0) {
                    const service = data[0]; // Asumsikan data pertama adalah JNE

                    // Looping melalui setiap biaya pengiriman
                    service.costs.forEach((cost, index) => {
                    cost.cost.forEach((item, itemIndex) => {
                        // Filter hanya layanan REG dan OKE
                        if (cost.description.toUpperCase().includes('REG') || cost.description.toUpperCase().includes('OKE')) {
                            const serviceItem = document.createElement('div');
                            serviceItem.classList.add('list-group-item');

                            const etd = item.etd || 'TBA'; // Jika tidak ada etd, tampilkan 'TBA'
                            const value = item.value ? `Rp ${new Intl.NumberFormat().format(item.value)}` : 'Rp 0';

                            // Gabungkan description dan service menjadi satu string
                            const shippingDescription = `${cost.description} (${cost.service})`;

                            serviceItem.innerHTML = `
                                <input type="radio" id="service-${index}-${itemIndex}" name="jenis_pengiriman" value="${shippingDescription}" class="form-check-input" onclick="updateShippingFee(${item.value}, '${shippingDescription}')">
                                <label for="service-${index}-${itemIndex}" class="form-check-label ms-3">
                                    <strong>${cost.description} (${cost.service})</strong><br>
                                    Estimated Delivery: ${etd} days<br>
                                    Price: ${value}
                                </label>
                            `;
                            availableServicesContainer.appendChild(serviceItem);
                        }
                    });
                });

                    availableServicesContainer.style.display = 'block'; // Tampilkan layanan pengiriman
                } else {
                    availableServicesContainer.style.display = 'none';
                }
            })
            .catch(err => {
                console.error('Error fetching shipping services:', err);
                availableServicesContainer.style.display = 'none';
            });
        }
    }

    // Fungsi untuk update ongkos kirim
    window.updateShippingFee = function(shippingFeeValue) {
        shippingFee = shippingFeeValue || 0; // Jika tidak ada ongkos kirim, anggap 0
        shippingFeeContainer.textContent = `Rp ${new Intl.NumberFormat().format(shippingFee)}`;

        document.getElementById('shipping-fee-input').value = shippingFee;

        // Menghitung Grand Total: SubTotal + Ongkos Kirim
        const grandTotal = subTotal + shippingFee;
        grandTotalContainer.textContent = `Rp ${new Intl.NumberFormat().format(grandTotal)}`;

         // Menyimpan layanan pengiriman yang dipilih
        document.getElementById('shipping-service-input').value = shippingService;
    }

    // Event listener untuk pilihan metode pengiriman
    shippingMethodRadioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Diantarkan') {
                alamatContainer.style.display = 'block';
                deliveryContainer.style.display = 'block';
                shippingFeeContainer.style.display = 'block'; // Reset ongkos kirim saat berpindah ke diantarkan
                availableServicesContainer.style.display = 'none'; // Hide available services saat "Diantarkan" dipilih, menunggu kota tujuan
                document.getElementById('alamat').setAttribute('required', 'required');
                document.getElementById('destination').setAttribute('required', 'required');
                document.getElementById('province').setAttribute('required', 'required');
                // Centang checkbox JNE secara otomatis
                document.getElementById('jne').checked = true;

                // Hapus data yang sudah ada pada available services jika ada
                const radioButtons = availableServicesContainer.querySelectorAll('input[type="radio"]');
                radioButtons.forEach(radio => radio.checked = false); // Reset pilihan radio
            } else {
                alamatContainer.style.display = 'none';
                deliveryContainer.style.display = 'none';
                shippingFee = 0;
                shippingFeeContainer.textContent = 'Rp 0'; // Ongkos kirim tetap 0
                shippingFeeContainer.style.display = 'block'; // Tampilkan ongkos kirim 0
                availableServicesContainer.style.display = 'none'; // Sembunyikan layanan pengiriman
                grandTotalContainer.textContent = `Rp ${new Intl.NumberFormat().format(subTotal)}`; // Update Grand Total
                document.getElementById('alamat').removeAttribute('required');
                document.getElementById('destination').removeAttribute('required');
                document.getElementById('province').removeAttribute('required');
                document.getElementById('jne').removeAttribute('required');
                // Reset checkbox JNE dan radio button
                document.getElementById('jne').checked = false;
                const radioButtons = availableServicesContainer.querySelectorAll('input[type="radio"]');
                radioButtons.forEach(radio => radio.checked = false);

                // Reset kota, provinsi, dan alamat
                destinationSelect.selectedIndex = 0;  // Reset pilihan kota ke default
                provinceInput.value = '';  // Kosongkan provinsi
                addressInput.value = ''; // Kosongkan alamat
            }
        });
    });

    // Event listener untuk pilihan kota
    destinationSelect.addEventListener('change', function() {
        const selectedCity = this.selectedOptions[0];
        const provinceName = selectedCity.dataset.province;
        provinceInput.value = provinceName;

        // Tampilkan layanan pengiriman hanya setelah memilih kota tujuan
        if (this.value) {
            updateShippingServices(this.value);
        }
    });

    // Event listener untuk checkbox JNE
    document.getElementById('jne').addEventListener('change', function() {
        if (this.checked) {
            // Jika JNE dicentang, dan kota sudah dipilih, tampilkan available services
            if (destinationSelect.value) {
                availableServicesContainer.style.display = 'block';
            }
        } else {
            availableServicesContainer.style.display = 'none';
            shippingFee = 0;
            shippingFeeContainer.textContent = 'Rp 0';
            grandTotalContainer.textContent = `Rp ${new Intl.NumberFormat().format(subTotal)}`;

            // Reset semua radio button ketika JNE di-uncheck
            const radioButtons = availableServicesContainer.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => radio.checked = false);
        }
    });

});

</script>
@endpush
