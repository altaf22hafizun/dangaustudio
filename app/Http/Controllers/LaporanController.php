<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LaporanController extends Controller
{
    public function penghasilan(Request $request)
    {
        $tahunSekarang = date('Y');

        $tanggalAwal = $request->input('tanggal_awal', $tahunSekarang . now()->format('-m-01'));
        $tanggalAkhir = $request->input('tanggal_akhir', $tahunSekarang . now()->format('-m-t'));

        $request->validate([
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:date_awal',
        ], [
            'tanggal_awal.date' => 'Tanggal awal harus berupa tanggal yang valid',
            'tanggal_akhir.date' => 'Tanggal akhir harus berupa tanggal yang valid',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir harus lebih besar atau sama dengan tanggal awal',
        ]);

        $query = Pesanan::whereIn('status', ['Selesai']);

        // Apply rentang tanggal jika ada
        if ($tanggalAwal && $tanggalAkhir) {
            $query->whereBetween('tgl_transaksi', [$tanggalAwal, $tanggalAkhir]);
        }

        // Mengambil data per bulan dan tahun
        $data = $query->get()->groupBy(function ($date) {
            return Carbon::parse($date->tgl_transaksi)->format('Y-m');
        });

        // Menyiapkan data untuk laporan
        $laporan = [];
        $dataBulan = [];
        $dataTotalPenghasilan = [];
        $totalKeseluruhan = 0;
        $totalRataRata = 0;
        $maxPenghasilan = 0;
        $minPenghasilan = null;

        foreach ($data as $key => $group) {
            $totalPenghasilan = 0;
            $min = null;
            $max = 0;

            foreach ($group as $item) {
                $penghasilan = $item->price_total - $item->ongkir;
                $totalPenghasilan += $penghasilan;

                // Menghitung min dan max penghasilan hanya jika ada penghasilan valid
                if ($min === null || $penghasilan < $min) $min = $penghasilan;
                if ($penghasilan > $max) $max = $penghasilan;
            }

            $rataRata = count($group) ? $totalPenghasilan / count($group) : 0;

            // Menyimpan data periode dan penghasilan
            $laporan[] = [
                'periode' => Carbon::createFromFormat('Y-m', $key)->format('F Y'),
                'total' => $totalPenghasilan,
                'rata_rata' => $rataRata,
                'max' => $max,
                'min' => $min,
            ];

            // Untuk grafik
            $dataBulan[] = Carbon::createFromFormat('Y-m', $key)->format('F Y');
            $dataTotalPenghasilan[] = $totalPenghasilan;

            // Menambahkan total penghasilan ke total keseluruhan
            $totalKeseluruhan += $totalPenghasilan;
            $totalRataRata += $rataRata;
            if ($max > $maxPenghasilan) $maxPenghasilan = $max;
            if ($min !== null && ($min < $minPenghasilan || $minPenghasilan === null)) $minPenghasilan = $min;
        }

        // Menghitung rata-rata keseluruhan
        $totalData = count($data);
        $rataRataKeseluruhan = $totalData ? $totalRataRata / $totalData : 0;

        // Mengirim data ke view
        return view('admin.laporan.penghasilan.index', compact(
            'laporan',
            'dataBulan',
            'dataTotalPenghasilan',
            'tanggalAwal',
            'tanggalAkhir',
            'tahunSekarang',
            'totalKeseluruhan',
            'rataRataKeseluruhan',
            'maxPenghasilan',
            'minPenghasilan'
        ));
    }

    // contoh transaksi awal
    // public function transaksi(Request $request)
    // {
    //     // Mendapatkan tahun sekarang
    //     $tahunSekarang = date('Y');

    //     $tanggalAwal = $request->input('tanggal_awal', $tahunSekarang . now()->format('-m-01'));
    //     $tanggalAkhir = $request->input('tanggal_akhir', $tahunSekarang . now()->format('-m-t'));

    //     // Validasi untuk tanggal
    //     $request->validate([
    //         'tanggal_awal' => 'nullable|date',
    //         'tanggal_akhir' => 'nullable|date|after_or_equal:date_awal',
    //     ]);

    //     // Query pesanan yang statusnya "Selesai" dan dalam rentang tanggal
    //     $query = Pesanan::whereBetween('tgl_transaksi', [$tanggalAwal, $tanggalAkhir]);

    //     // Mengambil data transaksi
    //     $data = $query->get();

    //     // Menghitung statistik transaksi
    //     $totalTransaksi = $data->count();
    //     $totalBerhasil = $data->where('status', 'Selesai')->count();
    //     $totalDikirim = $data->where('status', 'Dikirim')->count();
    //     $totalDikemas = $data->where('status', 'Dikemas')->count();
    //     $totalBelumDibayar = $data->where('status', 'Belum Dibayar')->count();
    //     $totalGagal = $data->where('status', 'Dibatalkan')->count();
    //     $rataRataTransaksi = $totalTransaksi > 0 ? $data->sum(function ($item) {
    //         return $item->price_total - $item->ongkir;
    //     }) / $totalTransaksi : 0;


    //     $dataPeriode = $data->groupBy(function ($item) {
    //         return Carbon::parse($item->tgl_transaksi)->format('Y-m');
    //     });

    //     // Menyiapkan data untuk grafik dan tabel
    //     $dataBulan = [];
    //     $dataJumlahTransaksi = [];

    //     foreach ($dataPeriode as $key => $group) {
    //         $dataBulan[] = $key;
    //         $dataJumlahTransaksi[] = $group->count();
    //     }

    //     // Menyiapkan data untuk view
    //     return view('admin.laporan.transaksi.index', compact(
    //         'dataBulan',
    //         'dataJumlahTransaksi',
    //         'totalTransaksi',
    //         'totalDikirim',
    //         'totalDikemas',
    //         'totalBelumDibayar',
    //         'totalBerhasil',
    //         'totalGagal',
    //         'rataRataTransaksi',
    //         'tanggalAwal',
    //         'tanggalAkhir'
    //     ));
    // }

    public function transaksi(Request $request)
    {
        // Mendapatkan tahun sekarang
        $tahunSekarang = date('Y');

        // Default tanggal awal dan akhir untuk tahun sekarang
        $tanggalAwal = $request->input('tanggal_awal', $tahunSekarang . '-01-01');
        $tanggalAkhir = $request->input('tanggal_akhir', $tahunSekarang . '-12-31');

        // Validasi untuk tanggal
        $request->validate([
            'tanggal_awal' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:date_awal',
        ]);

        // Query pesanan dalam rentang tanggal
        $data = Pesanan::whereBetween('tgl_transaksi', [$tanggalAwal, $tanggalAkhir])->get();

        // Menghitung statistik transaksi
        $totalTransaksi = $data->count();
        $totalBerhasil = $data->where('status', 'Selesai')->count();
        $totalDibatalkan = $data->where('status', 'Dibatalkan')->count();
        $totalDikirim = $data->where('status', 'Dikirim')->count();
        $totalDikemas = $data->where('status', 'Dikemas')->count();
        $totalGagal = $data->where('status', 'Dibatalkan')->count();
        $totalBelumDibayar = $data->where('status', 'Belum Dibayar')->count();

        // Rata-rata transaksi yang berhasil
        $rataRataTransaksi = $totalBerhasil > 0 ? $data->where('status', 'Selesai')->sum(function ($item) {
            return $item->price_total - $item->ongkir;
        }) / $totalBerhasil : 0;

        // Mengelompokkan transaksi berdasarkan bulan atau minggu
        $dataPeriode = $data->groupBy(function ($item) use ($request) {
            return Carbon::parse($item->tgl_transaksi)->format('F Y');

        });

        // Data untuk grafik frekuensi transaksi
        $dataBulan = [];
        $dataJumlahTransaksi = [];
        foreach ($dataPeriode as $key => $group) {
            $dataBulan[] = $key;
            $dataJumlahTransaksi[] = $group->count();
        }

        // Persentase Transaksi
        $persenBerhasil = $totalTransaksi > 0 ? ($totalBerhasil / $totalTransaksi) * 100 : 0;
        $persenDibatalkan = $totalTransaksi > 0 ? ($totalDibatalkan / $totalTransaksi) * 100 : 0;
        // $persenDikemas = $totalTransaksi > 0 ? ($totalDikemas / $totalTransaksi) * 100 : 0;
        $persenBelumBayar = $totalTransaksi > 0 ? ($totalBelumDibayar / $totalTransaksi) * 100 : 0;

        // Mengirim data ke view
        return view('admin.laporan.transaksi.index', compact(
            'dataBulan',
            'dataJumlahTransaksi',
            'totalTransaksi',
            'totalBerhasil',
            'totalDibatalkan',
            'totalDikirim',
            'totalGagal',
            'totalDikemas',
            'totalBelumDibayar',
            'rataRataTransaksi',
            'persenBerhasil',
            'persenDibatalkan',
            // 'persenDikemas',
            'persenBelumBayar',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    // contoh awal
    // public function transaksi(Request $request)
    // {
    //     $request->validate([
    //         'tahun' => 'nullable|digits:4|integer',
    //     ], [
    //         'tahun.digits' => 'Format tahun harus terdiri dari 4 digit',
    //     ]);

    //     // Mengambil tahun yang dipilih, jika tidak ada maka menggunakan tahun saat ini
    //     $tahun = $request->input('tahun', date('Y'));

    //     // Simpan nilai input ke dalam session untuk digunakan di blade
    //     Session::put('search_tahun', $tahun);

    //     $bulan = 12;

    //     // Arrays untuk menyimpan data yang akan digunakan pada grafik
    //     $dataBulan = [];
    //     $dataTotalPenjualan = [];
    //     $totalKeseluruhan = 0; // Menyimpan total penghasilan keseluruhan

    //     // Looping untuk mengumpulkan data bulan, total penjualan
    //     for ($i = 1; $i <= $bulan; $i++) {
    //         // Menghitung Total Penjualan berdasarkan bulan dan status "Selesai"
    //         $totalTerjual = Pesanan::whereYear('tgl_transaksi', $tahun)
    //             ->whereIn('status', ['Selesai'])
    //             ->whereMonth('tgl_transaksi', $i)
    //             ->get();

    //         $totalPenghasilan = 0;

    //         // Mengurangi harga total dengan ongkir untuk setiap transaksi
    //         foreach ($totalTerjual as $item) {
    //             $totalPenghasilan += $item->price_total - $item->ongkir; // Menghitung harga total dikurangi ongkir
    //         }

    //         // Memasukkan hasil perhitungan ke dalam array untuk grafik dan tabel
    //         $dataBulan[] = Carbon::create()->month($i)->format('F');
    //         $dataTotalPenjualan[] = $totalPenghasilan;

    //         // Menambahkan total penghasilan bulan ini ke total keseluruhan
    //         $totalKeseluruhan += $totalPenghasilan;
    //     }

    //     // Mengirim data ke view
    //     return view('admin.laporan.transaksi.index', compact('tahun', 'dataBulan', 'dataTotalPenjualan', 'totalKeseluruhan'));
    // }
}
