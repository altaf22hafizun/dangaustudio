@extends('landing.layouts.index')
@section('title', 'Keranjang | Dangau Studio')
@section('menuCart', 'active')
@section('content')

<section>
    <div class="container mt-5 px-4">
        <h2 class="mb-5 text-success">Keranjang Belanja</h2>
        <form action="{{ route('pesanan.index') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-8 shadow p-3 mb-5">
                    <!-- Checkbox untuk pilih semua -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="select-all">
                        <label class="form-check-label" for="select-all">Pilih Semua Item</label>
                    </div>

                    @foreach ($pesanans as $pesanan)
                    <div class="cart-item border p-3 mb-3 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img src="{{ Storage::url($pesanan->karya->image) }}" alt="Karya" class="img-fluid rounded">
                            </div>
                            <div class="col-6">
                                <h5 class="text-dark">{{ $pesanan->karya->name }}</h5>
                                <p class="text-muted">Seniman: <strong>{{ $pesanan->karya->seniman->name }}</strong></p>
                                @if ($pesanan->karya->stock == 'Terjual')
                                    <p class="text-danger fw-bold">TERJUAL</p>
                                @else
                                    <p class="text-danger fw-bold">Rp {{ number_format($pesanan->price, 0, ',', '.') }}</p>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input item-checkbox" name="selected_items[]" value="{{ $pesanan->price }}" id="item-{{ $pesanan->id }}">
                                        <label class="form-check-label" for="item-{{ $pesanan->id }}">Pilih Item</label>
                                    </div>
                                @endif
                            </div>
                            <div class="col-4 text-end">
                                <a href="{{ route('cart.destroy', $pesanan->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <div class="border p-3 shadow-sm mb-5">
                        <h4 class="text-success">Ringkasan Belanja</h4>
                        <div class="d-flex justify-content-between">
                            <span>Total Item:</span>
                            <span id="total-items">0</span>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <span>Total:</span>
                            <span id="total-price">Rp 0</span>
                        </div>
                        <button type="submit" class="btn btn-success w-100 mt-3">Lanjutkan ke Pembayaran</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@push('custom-script')
<script>
    // Script untuk mengatur checkbox "Pilih Semua"
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked; // Set semua checkbox sesuai dengan status "Pilih Semua"
        });
        updateSummary(); // Update ringkasan saat semua terpilih
    });

    // Update ringkasan ketika checkbox item diubah
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Jika semua checkbox dipilih, centang "Pilih Semua"
            const allChecked = Array.from(itemCheckboxes).every(item => item.checked);
            document.getElementById('select-all').checked = allChecked;
            updateSummary();
        });
    });

    function updateSummary() {
        let totalItems = 0;
        let totalPrice = 0;

        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalItems++;
                totalPrice += parseInt(checkbox.value);
            }
        });

        document.getElementById('total-items').innerText = totalItems;
        document.getElementById('total-price').innerText = 'Rp ' + totalPrice.toLocaleString('id-ID');
    }
</script>

@endpush
