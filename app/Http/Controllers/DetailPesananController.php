<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
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

        // dd($pesanans);

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

        // dd($request->all());
        $validateData = $request->validate([
            'pesanan_id' => 'required|array|min:1',
            'metode_pengiriman' => 'required|in:Dijemput,Diantarkan',
            'alamat' => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
            'destination' => 'nullable|required_if:metode_pengiriman,Diantarkan|integer',
            'province' => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
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

        // Dapatkan pesanan berdasarkan ID yang dipilih
        $pesanans = Pesanan::whereIn('id', $request->input('pesanan_id'))
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        //Jika pesanan tidak ditemukan
        if ($pesanans->isEmpty()) {
            return view('landing.pesanan.index')->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        // Tanggal transaksi otomatis menggunakan waktu sekarang
        $tglTransaksi = now();

        if ($request->input('metode_pengiriman') === 'Diantarkan') {
            // Ambil data alamat dan pengiriman

            $address = $request->input('alamat');
            $destination = $request->input('destination');
            $province = $request->input('province');


            //Pastikan data tujuan valid
            $cities = $this->rajaOngkir();
            $city = collect($cities)->firstWhere('city_id', $destination);
            $cityName = $city ? $city['city_name'] : '';

            $alamat = $address . ',' . $cityName . ',' . $province;
        }

        //Hitung GrandTotal
        $subtotal = $pesanans->sum('price');
        $shippingFee = $request->input('shipping_fee');
        $total_harga = $subtotal + $shippingFee;

        // Menyimpan detail pesanan ke database
        foreach ($pesanans as $pesanan) {
            // Simpan detail pesanan pada tabel detail_pesanan
            DetailPesanan::create([
                'pesanan_id' => $pesanan->id, // ID pesanan
                'status' => 'Pembayaran Berhasil', // Status pembayaran
                'tgl_transaksi' => $tglTransaksi, // Tanggal transaksi otomatis
                'total_harga' => $total_harga, // Total harga
                'metode_pengiriman' => $request->input('metode_pengiriman'),
                'alamat' => $alamat ?? null, // Alamat jika pengiriman 'Diantarkan'
                'shipping_fee' => $shippingFee, // Ongkir
                'status_pembayaran' => 'Lunas'
            ]);

            $karya = $pesanan->karya;
            if ($karya) {
                $karya->update([
                    'stock' => 'terjual',
                ]);
            }
        }

        // Ambil detail pesanan dari tabel DetailPesanan
        $detailPesanan = DetailPesanan::whereIn('pesanan_id', $request->input('pesanan_id'))->get();

        // dd($detailPesanan);

        return view('landing.pesanan.berhasil', [
            'pesanans' => $pesanans,
            'metode_pengiriman' => $request->input('metode_pengiriman'),
            'alamat' => $alamat ?? null,
            'total_harga' => $total_harga,
            'detailPesanan' => $detailPesanan,
        ])->with('success', 'Pembayaran Berhasil');
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
