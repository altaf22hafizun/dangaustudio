@extends('admin.layouts.index')
@section('title', 'Laporan Transaksi | Admin Dangau Studio')
@section('menuLaporan', 'active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Laporan Transaksi</h5>
        </div>

        <div class="col-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link p-3 " href="/admin/laporan/penghasilan"><i class="bi bi-person me-1"></i> Penghasilan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-3 active" href="/admin/laporan/transaksi"><i class="bi bi-signpost-split"></i> Transaksi</a>
                </li>
            </ul>
        </div>

        <!-- Form Filter -->
        <form action="{{ route('laporan.transaksi') }}" method="GET" class="border p-4 rounded shadow-sm mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_awal" class="mb-3">Tanggal Awal:</label>
                        <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control" value="{{ old('tanggal_awal', $tanggalAwal) }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="tanggal_akhir" class="mb-3">Tanggal Akhir:</label>
                        <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control" value="{{ old('tanggal_akhir', $tanggalAkhir) }}">
                    </div>
                </div>

                <div class="col-md-12 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Filter</button>
                </div>
            </div>
        </form>

        <!-- Statistik Transaksi -->
        <div class="row mb-4 d-flex justify-content-center align-items-center">
            {{-- <div class="col-md-3 ">
                <div class="card p-4 text-center">
                    <h5>Total Transaksi</h5>
                    <h4>{{ $totalTransaksi }}</h4>
                </div>
            </div> --}}
            <div class="col-md-2">
                <div class="card p-4 text-center">
                    <h5>Transaksi Berhasil</h5>
                    <h4>{{ $totalBerhasil }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card p-4 text-center">
                    <h5>Transaksi Dikirim</h5>
                    <h4>{{ $totalDikirim }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card p-4 text-center">
                    <h5>Transaksi Dikemas</h5>
                    <h4>{{ $totalDikemas }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card p-4 text-center">
                    <h5>Transaksi Belum Bayar</h5>
                    <h4>{{ $totalBelumDibayar }}</h4>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card p-4 text-center">
                    <h5>Transaksi Gagal</h5>
                    <h4>{{ $totalGagal }}</h4>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="card p-4 text-center">
                    <h5>Rata-rata Transaksi</h5>
                    <h4>Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</h4>
                </div>
            </div> --}}
        </div>

        <!-- Grafik Transaksi -->
        <div id="chart" class="my-4"></div>

        <!-- Tabel Transaksi -->
        <div class="table-responsive mt-4" data-simplebar>
            <table class="table table-bordered table-striped align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                    <tr>
                        <th scope="col" class="text-light">Periode</th>
                        <th scope="col" class="text-light">Jumlah Transaksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dataBulan as $index => $periode)
                        <tr>
                            <td>{{ $periode }}</td>
                            <td>{{ $dataJumlahTransaksi[$index] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">Maaf, tidak ada data yang tersedia untuk periode ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('custom-script')
<script>
    var options = {
        series: [
            {
                name: "Jumlah Transaksi",
                data: @json($dataJumlahTransaksi),
            },
        ],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: 'Jumlah Transaksi Per Periode',
            align: 'left',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Roboto, sans-serif'
            }
        },
        subtitle: {
            text: 'Jumlah Transaksi per Bulan/Minggu',
            align: 'left',
            margin: 30,
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'],
                opacity: 0.5
            },
        },
        xaxis: {
            categories: @json($dataBulan),
            labels: {
                style: {
                    fontSize: '14px'
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value.toLocaleString();
                }
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
