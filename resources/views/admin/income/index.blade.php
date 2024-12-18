@extends('admin.layouts.index')
@section('title', 'Income | Admin Dangau Studio')
@section('menuIncome','active')
@section('content')

<div class="card w-100">
    <div class="card-body p-4">
        <div class="d-flex mb-4 justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Income</h5>
            {{-- <a
            href="{{ route('karya.create') }}"
            class="btn btn-success rounded-3 btn-sm d-flex align-items-center py-2 px-3 me-2"
            role="button"
            >
            <i class="ti ti-plus fs-7 me-2"></i>
            Tambah Karya
            </a> --}}
        </div>
        {{-- <div class="card w-100">
            <div class="card-header p-4">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 fw-bold">Grafik Keuangan</h5>
                </div>
            </div>
            <div class="card-body">
                <div id="chart"></div>
            </div>
        </div> --}}
        <div class="card">
            <div class="card-body">
                <form action="" method="GET">
                    <div class="form-group">
                        <label for="tahun">Pilih Tahun:</label>
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
                    <th scope="col" class=" text-light">Gambar Karya</th>
                    <th scope="col" class=" text-light">Nama Seniman</th>
                    <th scope="col" class=" text-light">Nama Karya</th>
                    <th scope="col" class=" text-light">Harga</th>
                    <th scope="col" class=" text-light">Stock</th>
                    <th scope="col" class=" text-light">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    {{-- @forelse ( $karyas as $karya )
                    <tr>
                        <td>
                            @if ($karya->image)
                                <img src="{{ asset('storage/' . $karya->image) }}" alt="Gambar" class="img-fluid mb-3 mt-2 rounded-3" width="130">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $karya->seniman->name }}</td>
                        <td>{{ Str::limit($karya->name, 15) }}</td>
                        <td>Rp {{ number_format($karya->price, 0, ',', '.') }}</td>
                        <td>
                            @if ($karya->stock == 'Tersedia')
                                <span class="badge bg-light-success rounded-pill text-success px-3 py-2 fs-3">Tersedia</span>
                            @else
                                <span class="badge bg-light-danger rounded-pill text-danger px-3 py-2 fs-3">Terjual</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('karya.edit', $karya->id, ) }}" class="btn btn-warning"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('karya.destroy', $karya->id) }}" class="btn btn-danger" data-confirm-delete="true"><i class="ti ti-trash"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center pt-4">Belum ada data karya</td>
                    </tr>
                    @endforelse --}}
                </tbody>
            </table>
        <div class="d-flex justify-content-center mt-3">
            {{-- {{ $karyas->links() }} --}}
        </div>
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
        text: 'Laporan Keuangan Tahun {{ $tahun }}',
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
