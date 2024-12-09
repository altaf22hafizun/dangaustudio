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
        // Mengambil item yang dipilih dari form atau session
        $selectedItems = $request->input('selected_items', []);

        if (empty($selectedItems)) {
            return redirect()->route('cart.index')->with('error', 'Pilih setidaknya satu item.');
        }

        // Simpan data pesanan ke session
        session(['selected_items' => $selectedItems]);

        // Ambil pesanan berdasarkan item yang dipilih
        $pesanans = Pesanan::whereIn('price', $selectedItems)
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        if ($pesanans->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        $cities = $this->rajaOngkir();

        // Filter untuk kota Padang (ID: 318)
        $cityPadang = collect($cities)->firstWhere('city_id', 318);

        return view('landing.pesanan.index', [
            'pesanans' => $pesanans,
            'cities' => $cities,
            'cityPadang' => $cityPadang, 
        ]);
    }

    public function checkout(Request $request)
    {
        $validateData = $request->validate([
            'pesanan_id' => 'required|array|min:1',
            'metode_pengiriman' => 'required|in:Dijemput,Diantarkan',
            'alamat' => 'required_if:metode_pengiriman,Diantarkan|string',
            'destination' => 'required_if:metode_pengiriman,Diantarkan|integer',
            'province' => 'required_if:metode_pengiriman,Diantarkan|string',
        ], [
            'pesanan_id.required' => 'Harap pilih setidaknya satu pesanan untuk melanjutkan checkout.',
            'pesanan_id.min' => 'Harap pilih lebih dari satu pesanan untuk melanjutkan checkout.',

            'metode_pengiriman.required' => 'Metode pengiriman harus dipilih.',
            'metode_pengiriman.in' => 'Metode pengiriman tidak valid. Pilih antara Dijemput atau Diantarkan.',

            'alamat.required_if' => 'Alamat pengiriman harus diisi jika metode pengiriman dipilih "Diantarkan".',
            'alamat.string' => 'Alamat pengiriman harus berupa teks.',

            'destination.required_if' => 'Kota tujuan harus dipilih jika pengiriman diantarkan.',
            'province.required_if' => 'Provinsi harus diisi jika pengiriman diantarkan.',
        ]);

        //Dapatkan pesanan berdasarkan ID yang dipilih
        $pesanans = Pesanan::where('id', $request->input('pesanan_id'))
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        //Jika pesanan tidak ditemukan
        if ($pesanans->isEmpty()) {
            return view('landing.pesanan.index')->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        $cities = $this->rajaOngkir();

        // Ambil data alamat dan pengiriman
        $address = $request->input('alamat');
        $destination = $request->input('destination');
        $province = $request->input('province');

        // Jika destination (ID kota) dipilih, cari nama kota dari daftar kota
        if ($destination && $province) {
            $city = collect($cities)->firstWhere('city_id', $destination);
            $cityName = $city ? $city['city_name'] : '';
        }

        //Gabungkan alamat kota provinsi
        if ($cityName && $province) {
            $alamat = $address . ',' . $cityName . ',' . $province;
        }

        return view('landing.pesanan.berhasil', [
            'pesanans' => $pesanans,
            'metode_pengiriman' => $request->input('metode_pengiriman'),
            'alamat' => $alamat,
        ]);
    }

    /**
     * Handle the checkout process.
     */
    public function getShippingServices(Request $request)
    {
        // Ambil data dari request
        $destinationId = $request->destination;
        $origin = $request->origin;
        $weight = $request->weight;
        $courier = $request->courier;

        // Pastikan API Key Anda ada di .env file
        $apiKey = env('RAJAONGKIR_API_KEY');

        // Panggil API RajaOngkir untuk mendapatkan layanan pengiriman
        $response = Http::withHeaders([
            'key' => $apiKey,
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $origin,
            'destination' => $destinationId,
            'weight' => $weight,
            'courier' => $courier,
        ]);

        // Cek apakah respons API berhasil
        if ($response->successful()) {
            return response()->json($response->json()['rajaongkir']['results']);
        } else {
            return response()->json(['error' => 'Gagal mendapatkan layanan pengiriman'], 500);
        }
    }

    public function rajaOngkir()
    {
        // Ambil daftar kota dari RajaOngkir
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY')
        ])->get('https://api.rajaongkir.com/starter/city');

        if ($response->successful()) {
            return $response['rajaongkir']['results'];
        }

        return [];
    }
}
