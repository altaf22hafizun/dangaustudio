<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PesananController extends Controller
{
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
        $ids = array_keys($selectedItems);
        $pesanans = Keranjang::whereIn('id', $ids)
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
        // Validasi data dari request
        $validatedData = $request->validate([
            'pesanan_id'        => 'required|array|min:1',
            'metode_pengiriman' => 'required|in:Dijemput,Diantarkan',
            'alamat'            => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
            'destination'       => 'nullable|required_if:metode_pengiriman,Diantarkan|integer',
            'province'          => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
            'jenis_pengiriman'  => 'nullable|required_if:metode_pengiriman,Diantarkan|string',
        ]);

        // Cek apakah ada pesanan yang sedang menunggu pembayaran
        $pendingOrder = Pesanan::where('status_pembayaran', 'Menunggu Pembayaran dan Pengiriman')
            ->where('user_id', Auth::id())
            ->exists();

        // Jika ada pesanan yang statusnya "Menunggu Pembayaran"
        if ($pendingOrder) {
            return redirect()->route('pesanan.pembayaran')
                ->with('error', 'Anda memiliki pesanan yang masih menunggu pembayaran. Silakan selesaikan pembayaran terlebih dahulu.');
        }

        // Ambil data pesanan berdasarkan ID yang divalidasi
        $pesanans = Keranjang::whereIn('id', $validatedData['pesanan_id'])
            ->where('user_id', Auth::id())
            ->with('karya.seniman')
            ->get();

        // Jika pesanan tidak ditemukan
        if ($pesanans->isEmpty()) {
            return redirect()->route('pesanan.index')
                ->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        // Inisialisasi variabel transaksi
        $tglTransaksi = now();
        $alamat = null;
        // Ongkir default 0
        $shippingFee = $request->input('shipping_fee', 0);
        $shippingService = $request->input('jenis_pengiriman');

        // Jika metode pengiriman adalah "Diantarkan", validasi dan ambil detail alamat
        if ($validatedData['metode_pengiriman'] === 'Diantarkan') {
            // Ambil daftar kota melalui RajaOngkir
            $cities = $this->rajaOngkir();
            $city = collect($cities)->firstWhere('city_id', $validatedData['destination']);
            $cityName = $city ? $city['city_name'] : 'Unknown City';

            // Format alamat lengkap
            $alamat = $validatedData['alamat'] . ', ' . $cityName . ', ' . $validatedData['province'];
        }

        // Hitung subtotal dan total harga
        $subtotal = $pesanans->sum('price');
        $total_harga = $subtotal + $shippingFee;

        // Generate trx_id
        $trxId = Pesanan::generateUniqueTransaction();

        // Simpan pesanan utama
        $pesanan = Pesanan::create([
            'user_id'    => Auth::id(),
            'trx_id'     => $trxId,
            'price_total' => $total_harga,
            'tgl_transaksi'     => $tglTransaksi,
            'status_pembayaran' => 'Menunggu Pembayaran dan Pengiriman',
            'metode_pengiriman' => $validatedData['metode_pengiriman'],
            'alamat'            => $alamat,
            'resi_pengiriman'   => null,
            'jenis_pengiriman'  => $shippingService,
            'ongkir'  => $shippingFee,
        ]);

        // Simpan detail pesanan untuk setiap karya
        foreach ($pesanans as $pesananItem) {
            DetailPesanan::create([
                'pesanan_id'        => $pesanan->id,
                'karya_id'          => $pesananItem->karya_id,
                'price_karya'       => $pesananItem->price,
            ]);
        }
        return redirect()->route('pesanan.pembayaran');
    }

    public function pembayaran()
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->where('status_pembayaran', 'Menunggu Pembayaran dan Pengiriman')
            ->first();

        $detailPesanan = DetailPesanan::where('pesanan_id', $pesanan->id)
            ->get();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // Development mode
        \Midtrans\Config::$isSanitized = true;   // Data sanitasi aktif
        \Midtrans\Config::$is3ds = true;         // 3DS aktif untuk kartu kredit

        $params = [
            'transaction_details' => [
                'order_id'     => $pesanan->trx_id,
                'gross_amount' => $pesanan->price_total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'last_name'  => '',
                'email'      => Auth::user()->email,
                'phone'      => Auth::user()->telp,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('landing.pesanan.pembayaran', compact('pesanan', 'detailPesanan', 'snapToken'));
    }

    public function callback(Request $request, $trxId)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                $order = Pesanan::find($trxId);
                $order->update(['status_pembayaran' => 'Pembayaran Diterima, Sedang Diproses untuk Pengiriman']);
            }
        }
    }

    public function riwayatPesanan()
    {
        // Ambil parameter 'type' dari URL, jika ada
        $type = request('type');

        // Mulai query pesanan berdasarkan user yang login
        $pesananQuery = Pesanan::where('user_id', Auth::id())
            ->with('detailPesanans.karya') // Relasi dengan karya
            ->pencarian(); // Pencarian berdasarkan query 'search'

        // Jika ada filter 'type', gunakan scope untuk filter berdasarkan status pembayaran
        if ($type) {
            $pesananQuery->statusPembayaran($type); // Memanggil scope statusPembayaran
        }

        // Ambil pesanan yang sudah difilter
        $pesanan = $pesananQuery->get();

        // Kirim data pesanan dan parameter 'type' ke view
        return view('landing.user.riwayat', compact('pesanan', 'type'));
    }

    public function detailPembayaran($id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())
            ->where('id', $id)
            ->with('detailPesanans.karya')
            ->first();

            // dd($pesanan);
        return view('landing.pesanan.detail', compact('pesanan'));
    }

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
