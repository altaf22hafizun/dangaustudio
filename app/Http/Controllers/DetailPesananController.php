<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DetailPesananController extends Controller
{
    /**
     * Handle the post request and show selected items for payment.
     */
    public function index(Request $request)
    {
        // Menyimpan item yang dipilih di session
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Pilih setidaknya satu item.');
        }

        // Simpan ke session untuk digunakan di halaman pembayaran
        session(['selected_items' => $selectedItems]);

        // Ambil data pesanan berdasarkan harga yang dipilih
        $pesanans = Pesanan::whereIn('price', $selectedItems)
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        // Pastikan tidak ada pesanan yang kosong atau tidak valid
        if ($pesanans->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        // Cek kota tujuan dan ongkir
        $response = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];

        // Filter kota padang dengan city_id = 318
        $cityPadang = collect($cities)->firstWhere('city_id', 318);

        return view('landing.pesanan.index', [
            'pesanans' => $pesanans,
            'cities' => $cities,
            'cityPadang' => $cityPadang
        ]);
    }


    public function checkout(Request $request)
    {
        $request->request->add(['status_pembayaran' => 'Pending']);
        dd($request->all());

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => 'budi',
                'last_name' => 'pratama',
                'email' => 'budi.pra@example.com',
                'phone' => '08111222333',
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
    }

    public function riwayatPesanan()
    {
        return view('landing.user.riwayat');
    }

    public function cekOngkir()
    {
        $response = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];
        // $ongkir = $response['rajaongkir']['results'];

        return view('landing.pesanan.cekongkir', ['cities' => $cities, 'ongkir' => null]);
        // return view('landing.pesanan.cekongkir', ['cities' => $cities, 'ongkir' => '']);
    }

    public function ongkirKiriman(Request $request)
    {
        $response = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->get('https://api.rajaongkir.com/starter/city');

        // Mengambil data kota
        $cities = $response['rajaongkir']['results'];

        // Memanggil API untuk menghitung ongkir
        $responseCost = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,         // ID Kota Asal (Padang)
            'destination' => $request->destination,  // ID Kota Tujuan
            'weight' => $request->weight,            // Berat barang dalam gram
            'courier' => $request->courier,          // Kode kurir (jne, tiki, dll.)
        ]);

        $ongkir = $responseCost['rajaongkir']; // Ongkir yang diterima dari API RajaOngkir

        return view('landing.pesanan.cekongkir', [
            'cities' => $cities,  // Mengirimkan data kota
            'ongkir' => $ongkir    // Mengirimkan data ongkir untuk ditampilkan
        ]);
    }
}
