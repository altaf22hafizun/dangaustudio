<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Event;
use App\Models\Karya;
use App\Models\Pameran;
use App\Models\Pesanan;
use App\Models\Seniman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function admin()
    {
        $senimanCount = Seniman::count();
        $karyaSeniCount = Karya::where('stock', 'Tersedia')->count();
        $eventCount = Pameran::where('status_publikasi', 'Published')->count();
        $userCount = User::where('role', 'user')->count();

        $bulan = 12;
        $tahun = now()->year;

        // Arrays untuk menyimpan data yang akan digunakan pada grafik
        $dataBulan = [];
        $dataTotalPenjualan = [];

        // Looping untuk mengumpulkan data bulan, total donasi, dan total pengeluaran
        for ($i = 1; $i <= $bulan; $i++) {
            // Menghitung Total Donasi
            $totalTerjual = Pesanan::whereYear('tgl_transaksi', $tahun)
                ->whereIn('status_pembayaran', ['Pengiriman Berhasil, Pembayaran Lunas'])
                ->whereMonth('tgl_transaksi', $i)
                ->sum('price_total');

            // Memasukkan hasil perhitungan ke dalam array
            $dataBulan[] = Carbon::create()->month($i)->format('F');
            $dataTotalPenjualan[] = $totalTerjual;
        }

        $upcomingEvents = Event::where('start_date', '>=', now())
            ->where('status_publikasi', 'Published')
            ->orderBy('start_date', 'asc')
            ->take(5)
            ->get();

        return view('admin.index', compact('upcomingEvents', 'senimanCount', 'karyaSeniCount', 'userCount', 'eventCount', 'tahun', 'dataTotalPenjualan', 'dataBulan'));
    }

    public function adminUser()
    {
        $users = User::where('role', 'user')
            ->whereNotNull('email_verified_at')
            ->latest()
            ->paginate(5);
        return view('admin.user.index', compact('users'));
    }

    public function index()
    {
        //Karya
        $karyas = Karya::where('stock', 'Tersedia')->inRandomOrder()->take(12)->get();
        $senimanIds = $karyas->pluck('seniman_id')->unique();
        $senimans = Seniman::whereIn('id', $senimanIds)->get();

        //pameran
        $pamerans = Pameran::where('status_publikasi', 'Published')->take(6)->get();
        //event
        $events = Event::where('status_publikasi', 'Published')->take(6)->get();
        //berita
        $beritas = Berita::where('status_publikasi', 'Published')->take(6)->get();

        //seniman
        $senimans = Seniman::inRandomOrder()->take(12)->get();
        foreach ($senimans as $seniman) {
            $seniman->medsos_name = basename(rtrim($seniman->medsos, '/'));
        }
        return view('landing.index', compact('senimans', 'karyas', 'pamerans', 'events', 'beritas'));
    }
    public function tentang()
    {
        return view('landing.tentang.index');
    }
}
