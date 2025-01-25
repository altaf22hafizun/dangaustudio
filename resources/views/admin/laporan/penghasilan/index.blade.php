@extends('admin.layouts.index')
@section('title', 'Laporan | Admin Dangau Studio')
@section('menuLaporan','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Laporan Penghasilan</h5>
        </div>

        <div class="col-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link p-3 active" href="/admin/laporan/penghasilan"><i class="bi bi-person me-1"></i> Penghasilan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link p-3 " href="/admin/laporan/transaksi"><i class="bi bi-signpost-split"></i> Transaksi</a>
                </li>
            </ul>
        </div>

        <!-- Form Filter -->
        <form action="{{ route('laporan.penghasilan') }}" method="GET" class="border p-4 rounded shadow-sm mb-4">
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

        <!-- Grafik -->
        <div id="chart" class="my-4"></div>

        <!-- Tabel Laporan Penghasilan -->
        <div class="table-responsive mt-4" data-simplebar>
            <table class="table table-bordered table-striped align-middle text-nowrap text-center">
                <thead class="table-success text-center">
                    <tr>
                        <th scope="col" class="text-light">Periode</th>
                        <th scope="col" class="text-light">Rata-rata Penghasilan</th>
                        <th scope="col" class="text-light">Max Penghasilan</th>
                        <th scope="col" class="text-light">Min Penghasilan</th>
                        <th scope="col" class="text-light">Total Penghasilan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $item['periode'] }}</td>
                        <td>Rp {{ number_format($item['rata_rata'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item['max'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item['min'], 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-muted">Maaf, tidak ada data yang tersedia untuk periode ini</td>
                    </tr>
                @endforelse

                @if($totalKeseluruhan || $rataRataKeseluruhan || $maxPenghasilan || $minPenghasilan)
                    <tr class="table-success">
                        <td class="fw-bold">Total</td>
                        <td>Rp {{ number_format($rataRataKeseluruhan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($maxPenghasilan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($minPenghasilan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($totalKeseluruhan, 0, ',', '.') }}</td>
                    </tr>
                @endif
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
                name: "Total Penghasilan",
                data: @json($dataTotalPenghasilan),
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
            text: 'Laporan Penghasilan',
            align: 'left',
            style: {
                fontSize: '20px',
                fontWeight: 'bold',
                fontFamily: 'Roboto, sans-serif'
            }
        },
        subtitle: {
            text: 'Penghasilan per Periode',
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
                    return value.toLocaleString("id-ID", { style: "currency", currency: "IDR" });
                }
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
@endpush
