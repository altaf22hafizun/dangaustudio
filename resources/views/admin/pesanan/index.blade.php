@extends('admin.layouts.index')
@section('title', 'Pesanan | Admin Dangau Studio')
@section('menuPesanan','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="nav d-flex flex-column flex-md-row mb-3 align-items-md-center">
            <h5 class="mb-3 fw-bold me-md-auto">Pesanan</h5>
        </div>

        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                <tr>
                    <th scope="col" class=" text-light">Order ID</th>
                    <th scope="col" class=" text-light">Nama Pembeli</th>
                    <th scope="col" class=" text-light">Tanggal Transaksi</th>
                    <th scope="col" class=" text-light">Metode Pengiriman</th>
                    <th scope="col" class=" text-light">Status</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    @forelse ( $pesanans as $pesanan )
                    <tr>
                        <td>{{ $pesanan->trx_id }}</td>
                        <td>{{ $pesanan->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($pesanan->tgl_transaksi)->format('d-m-Y') }}</td>
                        <td>{{ $pesanan->metode_pengiriman }}</td>
                        <td><span class="btn
                            {{ $pesanan->status == 'Dikemas' ? 'btn-warning' : '' }}
                            {{ $pesanan->status == 'Selesai' ? 'btn-success' : '' }}
                            {{ $pesanan->status == 'Belum Dibayar' ? 'btn-danger' : '' }}
                            {{ $pesanan->status == 'Dikirim' ? 'btn-primary' : '' }}
                            {{ $pesanan->status == 'Dibatalkan' ? 'btn-secondary' : '' }}">
                            @switch($pesanan->status)
                            @case('Dikemas')
                                Dikemas
                                @break
                            @case('Selesai')
                                Selesai
                                @break
                            @case('Belum Dibayar')
                                Belum Dibayar
                                @break
                            @case('Dikirim')
                                Dikirim
                                @break
                            @case('Dibatalkan')
                                Dibatalkan
                                @break
                            @endswitch
                        </span></td>
                        <td>
                            <a href="" class="btn btn-danger"><i class="ti ti-eye"></i></a>
                            <a href="{{ route('pesanan.admin.edit', $pesanan->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{ $pesanans->links() }}
        </div>
        </div>
    </div>
</div>

@endsection
