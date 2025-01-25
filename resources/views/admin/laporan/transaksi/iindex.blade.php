@extends('admin.layouts.index')
@section('title', 'Laporan | Admin Dangau Studio')
@section('menuLaporan','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Laporan</h5>
        </div>
        <div class="col-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link p-3" href="/admin/laporan/penghasilan"><i class="bi bi-person me-1"></i> Penghasilan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-3 active" href="/admin/laporan/transaksi"><i class="bi bi-signpost-split"></i>
                        Transaksi</a>
                </li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="form-group mb-3">
                        <label for="tahun" class="mb-3">Pilih Tahun:</label>
                        <input type="number" id="tahun" name="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Masukkan tahun" value="{{ Session::get('search_tahun') }}">
                        @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </form>
                <div id="chart"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <div class="table-responsive" data-simplebar>
            <table class="table table-borderless align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                    <tr>
                        <th scope="col" class="text-light">Bulan</th>
                        <th scope="col" class="text-light">Total Penghasilan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataBulan as $index => $bulan)
                        <tr>
                            <td>{{ $bulan }}</td>
                            <td>Rp {{ number_format($dataTotalPenjualan[$index], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="">
                        <td class="text-light bg-success">Total Penghasilan</td>
                        <td class="text-dark fw-bold">Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                    </tr>
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
                name: "Terjual",
                data: @json($dataTotalPenjualan),
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
            curve: 'straight'
        },
        title: {
            text: 'Laporan Penghasilan Tahun {{ $tahun }}',
            align: 'left',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Roboto, sans-serif'
            }
        },
        subtitle: {
            text: 'Total Penjualan Setiap Bulan',
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
            categories: @json($dataBulan)
        },
        yaxis: {
            labels: {
                formatter: function(value){
                    return value.toLocaleString("id-ID",{style:"currency", currency:"IDR"});
                }
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
