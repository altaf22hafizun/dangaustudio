<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Pesanan;
use Carbon\Carbon;
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
        // Validasi data dari request
        $validatedData = $request->validate([
            'pesanan_id'        => 'required|array|min:1',
            'metode_pengiriman' => 'required|in:Dijemput,Diantarkan',
            'alamat'            => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
            'destination'       => 'nullable|required_if:metode_pengiriman,Diantarkan|integer',
            'province'          => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
        ], [
            'pesanan_id.required'        => 'Harap pilih setidaknya satu pesanan untuk melanjutkan checkout.',
            'pesanan_id.min'             => 'Harap pilih lebih dari satu pesanan untuk melanjutkan checkout.',
            'metode_pengiriman.required' => 'Metode pengiriman harus dipilih.',
            'metode_pengiriman.in'       => 'Metode pengiriman tidak valid. Pilih antara Dijemput atau Diantarkan.',
            'alamat.required_if'         => 'Alamat pengiriman harus diisi jika metode pengiriman dipilih "Diantarkan".',
            'alamat.string'              => 'Alamat pengiriman harus berupa teks.',
            'destination.required_if'    => 'Kota tujuan harus dipilih jika pengiriman diantarkan.',
            'province.required_if'       => 'Provinsi harus diisi jika pengiriman diantarkan.',
        ]);

        // Ambil data pesanan berdasarkan ID yang divalidasi
        $pesanans = Pesanan::whereIn('id', $validatedData['pesanan_id'])
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        // Jika pesanan tidak ditemukan
        if ($pesanans->isEmpty()) {
            return redirect()->route('landing.pesanan.index')
                ->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        // Inisialisasi variabel transaksi
        $tglTransaksi = now();
        $alamat = null;
        // Ongkir default 0
        $shippingFee = $request->input('shipping_fee', 0);

        // Jika metode pengiriman adalah "Diantarkan", validasi dan ambil detail alamat
        if ($validatedData['metode_pengiriman'] === 'Diantarkan') {
            $cities = $this->rajaOngkir(); // Ambil daftar kota melalui RajaOngkir
            $city = collect($cities)->firstWhere('city_id', $validatedData['destination']);
            $cityName = $city ? $city['city_name'] : 'Unknown City';

            // Format alamat lengkap
            $alamat = $validatedData['alamat'] . ', ' . $cityName . ', ' . $validatedData['province'];
        }

        // Hitung subtotal dan total harga
        $subtotal = $pesanans->sum('price');
        $total_harga = $subtotal + $shippingFee;

        // Generate trx_id
        $trxId = DetailPesanan::generateUniqueTransaction();

        // Simpan detail pesanan ke database
        foreach ($pesanans as $pesanan) {
            $detailPesanan = DetailPesanan::create([
                'trx_id'             => $trxId,
                'pesanan_id'         => $pesanan->id,
                'status'             => 'Pembayaran Berhasil',
                'tgl_transaksi'      => $tglTransaksi,
                'total_harga'        => $total_harga,
                'metode_pengiriman'  => $validatedData['metode_pengiriman'],
                'alamat'             => $alamat,
                'shipping_fee'       => $shippingFee,
            ]);

            // Update stok karya terkait
            if ($detailPesanan->status_pembayaran === 'Lunas') {
                // Update stok karya terkait
                $karya = $pesanan->karya;
                if ($karya) {
                    $karya->update(['stock' => 'terjual']);
                }
            }
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // Development mode
        \Midtrans\Config::$isSanitized = true;   // Data sanitasi aktif
        \Midtrans\Config::$is3ds = true;         // 3DS aktif untuk kartu kredit

        $params = [
            'transaction_details' => [
                'order_id'     => $trxId,
                'gross_amount' => $total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'last_name'  => '',
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->telp,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        // Ambil detail pesanan dari tabel DetailPesanan
        $detailPesanan = DetailPesanan::whereIn('pesanan_id', $validatedData['pesanan_id'])->get();

        // Tampilkan halaman checkout sukses
        return view('landing.pesanan.berhasil', [
            'pesanans'          => $pesanans,
            'metode_pengiriman' => $validatedData['metode_pengiriman'],
            'alamat'            => $alamat,
            'total_harga'       => $total_harga,
            'detailPesanan'     => $detailPesanan,
            'snapToken'          => $snapToken,
        ])->with('success', 'Pembayaran Berhasil');
    }

    public function callback(Request $request, $trxId)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $order = DetailPesanan::find($trxId);
                $order->update(['status_pembayaran' => 'Lunas']);
            }
        }
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
