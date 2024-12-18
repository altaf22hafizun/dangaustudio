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

        $tahun = $request->input('tahun', date('Y'));

        // Simpan nilai input ke dalam session
        Session::put('search_tahun', $request->tahun);

        $bulan = 12;

        // Arrays untuk menyimpan data yang akan digunakan pada grafik
        $dataBulan = [];
        $dataTotalPenjualan = [];

        // Looping untuk mengumpulkan data bulan, total donasi, dan total pengeluaran
        for ($i = 1; $i <= $bulan; $i++) {
            // Menghitung Total Donasi
            $totalTerjual = Pesanan::whereYear('tgl_transaksi', $tahun)
                ->whereIn('status', ['Selesai'])
                ->whereMonth('tgl_transaksi', $i)
                ->sum('price_total');

            // Memasukkan hasil perhitungan ke dalam array
            $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataTotalPenjualan[] = $totalTerjual;
        }
        return view('admin.income.index', compact('tahun', 'dataBulan', 'dataTotalPenjualan'));
    }
}
