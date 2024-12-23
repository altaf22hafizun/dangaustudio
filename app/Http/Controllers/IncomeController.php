<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'tahun' => 'nullable|digits:4|integer',
        ], [
            'tahun.digits' => 'Format tahun harus terdiri dari 4 digit',
        ]);

        // Mengambil tahun yang dipilih, jika tidak ada maka menggunakan tahun saat ini
        $tahun = $request->input('tahun', date('Y'));

        // Simpan nilai input ke dalam session untuk digunakan di blade
        Session::put('search_tahun', $tahun);

        $bulan = 12;

        // Arrays untuk menyimpan data yang akan digunakan pada grafik
        $dataBulan = [];
        $dataTotalPenjualan = [];
        $totalKeseluruhan = 0; // Menyimpan total penghasilan keseluruhan

        // Looping untuk mengumpulkan data bulan, total penjualan
        for ($i = 1; $i <= $bulan; $i++) {
            // Menghitung Total Penjualan berdasarkan bulan dan status "Selesai"
            $totalTerjual = Pesanan::whereYear('tgl_transaksi', $tahun)
                ->whereIn('status', ['Selesai'])
                ->whereMonth('tgl_transaksi', $i)
                ->get();

            $totalPenghasilan = 0;

            // Mengurangi harga total dengan ongkir untuk setiap transaksi
            foreach ($totalTerjual as $item) {
                $totalPenghasilan += $item->price_total - $item->ongkir; // Menghitung harga total dikurangi ongkir
            }

            // Memasukkan hasil perhitungan ke dalam array untuk grafik dan tabel
            $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataTotalPenjualan[] = $totalPenghasilan;

            // Menambahkan total penghasilan bulan ini ke total keseluruhan
            $totalKeseluruhan += $totalPenghasilan;
        }

        // Mengirim data ke view
        return view('admin.income.index', compact('tahun', 'dataBulan', 'dataTotalPenjualan', 'totalKeseluruhan'));
    }
}
