@extends('admin.layouts.index')

@section('title', 'Pesanan | Admin Dangau Studio')
@section('menuPesanan','active')
@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Edit Pesanan</h5>
        <form action="{{ route('pesanan.admin.update', $pesanans->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="table-responsive" data-simplebar>
                <table class="table table-bordered table-sm align-middle text-nowrap text-center">
                    <thead class="table-success">
                        <tr>
                            <th class="text-light py-3">Gambar Karya</th>
                            <th class="text-light py-3">Nama Karya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanans->detailPesanans as $detail)
                            <tr>
                                <td class="align-middle py-4">
                                    @if ($detail->karya->image)
                                        <img src="{{ asset('storage/' . $detail->karya->image) }}" alt="Gambar" class="img-fluid rounded-3" style="max-width: 120px; height: 150px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="align-middle">{{ $detail->karya->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <!-- Kolom pertama -->
                <div class="col-lg-6">
                    <!-- Order ID -->
                    <div class="mb-3">
                        <label for="trx_id">Order ID</label>
                        <input type="text" name="trx_id" id="trx_id" class="form-control rounded-0 @error('trx_id') is-invalid @enderror" readonly value="{{ old('trx_id', $pesanans->trx_id) }}">
                        @error('trx_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama Pembeli -->
                    <div class="mb-3">
                        <label for="name">Nama Pembeli</label>
                        <input type="text" name="name" id="name" class="form-control rounded-0 @error('name') is-invalid @enderror" readonly value="{{ old('name', $pesanans->user->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tanggal beli -->
                    <div class="mb-3">
                        <label for="tgl_transaksi">Tanggal Transaksi</label>
                        <input type="text" name="tgl_transaksi" id="tgl_transaksi" class="form-control rounded-0 @error('tgl_transaksi') is-invalid @enderror" readonly value="{{ old('tgl_transaksi', $formatTgl) }}">
                        @error('tgl_transaksi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Metode Pengiriman -->
                    <div class="mb-3">
                        <label for="metode_pengiriman">Metode Pengiriman</label>
                        <input type="text" name="metode_pengiriman" id="metode_pengiriman" class="form-control rounded-0 @error('metode_pengiriman') is-invalid @enderror" readonly value="{{ old('metode_pengiriman', $pesanans->metode_pengiriman) }}">
                        @error('metode_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Alamat Pembeli -->
                    <div class="mb-3">
                        <label for="alamat">Alamat Pembeli</label>
                        <input type="text" name="alamat" id="alamat" class="form-control rounded-0 @error('alamat') is-invalid @enderror" readonly value="{{ old('alamat', $pesanans->alamat) }}">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <!-- Kolom kedua -->
                <div class="col-lg-6">
                    <!-- Resi Pengiriman -->
                    <div class="mb-3">
                        <label for="resi_pengiriman">Resi Pengiriman <span class="text-danger">*</span></label>
                        <input type="text" name="resi_pengiriman" id="resi_pengiriman" class="form-control rounded-0 @error('resi_pengiriman') is-invalid @enderror" placeholder="Masukkan Resi Pengiriman" value="{{ old('resi_pengiriman', $pesanans->resi_pengiriman) }}">
                        @error('resi_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Telepon Pembeli -->
                    <div class="mb-3">
                        <label for="name">No.Telepon Pembeli</label>
                        <input type="text" name="telp" id="telp" class="form-control rounded-0 @error('telp') is-invalid @enderror" readonly value="{{ old('telp', $pesanans->user->telp) }}">
                        @error('telp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Jenis Pengiriman -->
                    <div class="mb-3">
                        <label for="jenis_pengiriman">Jenis Pengiriman</label>
                        <input type="text" name="jenis_pengiriman" id="jenis_pengiriman" class="form-control rounded-0 @error('jenis_pengiriman') is-invalid @enderror" readonly value="{{ old('jenis_pengiriman', $pesanans->jenis_pengiriman) }}">
                        @error('jenis_pengiriman')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ongkir Pengiriman -->
                    <div class="mb-3">
                        <label for="ongkir">Ongkir Pengiriman</label>
                        <input type="text" name="ongkir" id="ongkir" class="form-control rounded-0 @error('ongkir') is-invalid @enderror" readonly value="{{ old('ongkir', $pesanans->ongkir) }}">
                        @error('ongkir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Pilih Status -->
                    <div class="mb-3">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control rounded-0 @error('status') is-invalid @enderror">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            @foreach ($status as $stat)
                                <option value="{{ $stat }}" {{ old('status', $pesanans->status) == $stat ? 'selected' : '' }}>{{ $stat }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modal-footer mt-3">
                <a href="{{ route('pesanan.admin') }}" class="btn btn-secondary rounded-3 me-3">Kembali</a>
                <button type="submit" class="btn btn-success rounded-3">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection
