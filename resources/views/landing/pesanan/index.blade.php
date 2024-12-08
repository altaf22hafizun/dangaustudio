@extends('landing.layouts.index')
@section('title', 'Detail Pesanan | Dangau Studio')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Detail Pesanan</h2>
        <form action="" method="POST" enctype="multipart/form-data">
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
                                <input type="checkbox" class="form-check-input courier-code" id="jne" name="courier" value="jne">
                                <label for="courier" class="form-check-label">JNE</label>
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
    let shippingFee = 0;
    let subTotal = parseInt(totalPriceElement.textContent.replace('Rp ', '').replace(',', ''));

    // Pastikan elemen-elemen ini ada
    if (!shippingFeeContainer || !grandTotalContainer || !totalPriceElement) {
        console.error("Elemen untuk ongkos kirim atau total grand tidak ditemukan!");
        return;
    }

    // Fungsi untuk memperbarui data pengiriman
    function updateShippingServices(destinationId) {
        if (destinationId) {
            // Panggil API untuk mengambil data layanan pengiriman
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
                            const serviceItem = document.createElement('div');
                            serviceItem.classList.add('list-group-item');

                            // Cek apakah etd dan value ada, jika tidak beri nilai default
                            const etd = item.etd || 'TBA'; // Jika tidak ada etd, tampilkan 'TBA'
                            const value = item.value ? `Rp ${new Intl.NumberFormat().format(item.value)}` : 'Rp 0'; // Jika tidak ada value, tampilkan Rp 0

                            serviceItem.innerHTML = `
                                <input type="radio" id="service-${index}-${itemIndex}" name="shipping_service" value="${item.value}" class="form-check-input" onclick="updateShippingFee(${item.value})">
                                <label for="service-${index}-${itemIndex}" class="form-check-label ms-3">
                                    <strong>${cost.description} (${cost.service})</strong><br>
                                    Estimated Delivery: ${etd} days<br>
                                    Price: ${value}
                                </label>
                            `;
                            availableServicesContainer.appendChild(serviceItem);
                        });
                    });
                } else {
                    console.error('No shipping services found or data is in an unexpected format:', data);
                    availableServicesContainer.innerHTML = '<p>No available services found for this destination.</p>';
                }

                availableServicesContainer.style.display = 'block'; // Show services
            })
            .catch(error => {
                console.error('Error fetching services:', error);
                availableServicesContainer.innerHTML = '<p>Failed to fetch services.</p>';
                availableServicesContainer.style.display = 'block';
            });
        }
    }

    // Event listener untuk memilih kota tujuan
    destinationSelect.addEventListener('change', function() {
        const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
        const provinceName = selectedOption.getAttribute('data-province');
        provinceInput.value = provinceName || '';
    });

    // Menampilkan layanan pengiriman ketika JNE dipilih
    document.querySelectorAll('input[name="courier"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'jne') {
                const destinationId = destinationSelect.value;
                // Panggil API untuk mengambil data layanan pengiriman
                updateShippingServices(destinationId);
                availableServicesContainer.style.display = 'block';
            } else {
                // Menyembunyikan layanan pengiriman jika selain JNE
                availableServicesContainer.innerHTML = ''; // Clear the services list
                availableServicesContainer.style.display = 'none'; // Hide services list
            }
        });
    });

    // Update shipping fee and grand total when service is selected
    window.updateShippingFee = function(fee) {
        shippingFee = fee; // Update shipping fee

        // Update Ongkos Kirim
        if (shippingFeeContainer && grandTotalContainer) {
            shippingFeeContainer.style.display = 'block';
            shippingFeeContainer.querySelector('span').textContent = `Rp ${new Intl.NumberFormat().format(shippingFee)}`;

            // Calculate and update grand total
            const grandTotal = subTotal + shippingFee;
            grandTotalContainer.textContent = `Rp ${new Intl.NumberFormat().format(grandTotal)}`;
        }
    };

    // Menyembunyikan atau menampilkan alamat dan layanan pengiriman berdasarkan metode pengiriman
    shippingMethodRadioButtons.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'Diantarkan') {
                alamatContainer.style.display = 'block';
                deliveryContainer.style.display = 'block';
                // Reset form alamat dan layanan pengiriman
                resetForm();
            } else {
                alamatContainer.style.display = 'none';
                deliveryContainer.style.display = 'none';
                availableServicesContainer.style.display = 'none'; // Sembunyikan layanan pengiriman jika memilih "Dijemput"
            }
        });
    });

    // Fungsi untuk mereset form dan layanan pengiriman
    function resetForm() {
        // Reset alamat
        document.getElementById('address').value = '';
        destinationSelect.value = '';
        provinceInput.value = '';

        // Reset checkbox layanan pengiriman (JNE)
        document.querySelectorAll('input[name="courier"]').forEach((checkbox) => {
            checkbox.checked = false; // Uncheck all checkboxes
        });

        // Menyembunyikan dan mengosongkan layanan pengiriman
        availableServicesContainer.innerHTML = '';
        availableServicesContainer.style.display = 'none';

        // Reset ongkos kirim dan grand total
        shippingFee = 0;
        shippingFeeContainer.style.display = 'none';
        shippingFeeContainer.querySelector('span').textContent = 'Rp 0';

        // Reset grand total
        const grandTotal = subTotal;
        grandTotalContainer.textContent = `Rp ${new Intl.NumberFormat().format(grandTotal)}`;
    }
});
</script>
@endpush


