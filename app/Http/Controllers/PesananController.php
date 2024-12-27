<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class PesananController extends Controller
{

    public function test(Request $request)
    {
        // Ambil pesanan berdasarkan trx_id dan eager load relasi 'detailPesanans' dan 'karya'
        $order = Pesanan::where('trx_id', 'DNGSTDa02b5c79-621')
            ->with('detailPesanans.karya')  // Memastikan detailPesanan dan karya dimuat
            ->get();

        foreach ($order as $pesanan) {
            // Perbarui status pesanan menjadi 'Dikemas'
            $pesanan->update(['status' => 'Dikemas']);

            // Pastikan ada detailPesanans yang terhubung
            if ($pesanan->detailPesanans->isNotEmpty()) {
                // Debug: Dump seluruh detailPesanan tanpa menghentikan eksekusi
                // dump($pesanan->detailPesanans);  // Melihat semua data detailPesanans

                foreach ($pesanan->detailPesanans as $detailPesanan) {
                    // Debug: Dump setiap detailPesanan
                    // dump($detailPesanan);  // Melihat setiap detailPesanan tanpa menghentikan eksekusi

                    // Ambil karya terkait
                    $karya = $detailPesanan->karya;

                    // Debug: Dump karya yang terkait
                    // dump($karya);  // Melihat karya yang terkait dengan detailPesanan ini

                    // Tindakan lainnya: Menghapus karya terkait dari keranjang pengguna
                    if ($karya) {
                        // Update stok karya menjadi 'Terjual'
                        $karya->update(['stock' => 'Terjual']);
                        // dump('Stok karya telah diupdate menjadi Terjual: ' . $karya->name);

                        // // Dapatkan user_id dari pesanan
                        $userId = $pesanan->user_id;

                        // Temukan semua item keranjang yang berisi karya ini untuk pengguna yang bersangkutan
                        $userKeranjang = Keranjang::where('user_id', $userId)
                            ->where('karya_id', $karya->id) // Pastikan 'karya_id' sesuai dengan ID karya yang terkait
                            ->pluck('id'); // Ambil ID item keranjang yang sesuai

                        // Hapus karya dari keranjang
                        if ($userKeranjang->isNotEmpty()) {
                            Keranjang::destroy($userKeranjang); // Hapus item keranjang berdasarkan ID
                            // dump('Karya telah dihapus dari keranjang: ' . $karya->name);
                        } else {
                            // dump('Tidak ada karya yang ditemukan di keranjang untuk pengguna ini: ' . $karya->name);
                        }
                    }

                    dump('karya berhasil diperbarui dan dihapus dari keranjang' . $karya->name);
                }
            } else {
                dd('Tidak ada detailPesanan untuk pesanan ini.');
            }
        }

        return view('landing.pesanan.test');
    }

    public function admin()
    {

        $pesanans = Pesanan::with('detailPesanans.karya')
            ->paginate(12);

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function edit($id)
    {
        $pesanans = Pesanan::where('id', $id)
            ->with('detailPesanans.karya')
            ->findOrFail($id);


        $formatTgl = Carbon::parse($pesanans->tgl_transaksi)->format('d-M-Y');

        $status = [
            'Dikemas' => 'Dikemas',
            'Belum Dibayar' => 'Belum Dibayar',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan',
            'Dikirim' => 'Dikirim',
        ];

        return view('admin.pesanan.edit', compact('pesanans', 'status', 'formatTgl'));
    }

    public function update(Request $request, $id)
    {
        $pesanans = Pesanan::findOrFail($id);

        $validatedData = $request->validate([
            'status' => 'required|in:Belum Dibayar,Dikemas,Dikirim,Selesai,Dibatalkan',
            'resi_pengiriman' => "nullable|string",
        ]);

        Pesanan::where('id', $id)->update($validatedData);

        return redirect()->route('pesanan.admin')->with('success', 'Status pesanan berhasil diperbarui');
    }

    // User
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
        $pendingOrder = Pesanan::where('status', 'Belum Dibayar')
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

        $userAddress = Auth::user()->alamat;

        if ($userAddress) {
            $alamat = $userAddress;
        } else {
            // Jika metode pengiriman adalah "Diantarkan", validasi dan ambil detail alamat
            if ($validatedData['metode_pengiriman'] === 'Diantarkan') {
                // Ambil daftar kota melalui RajaOngkir
                $cities = $this->rajaOngkir();
                $city = collect($cities)->firstWhere('city_id', $validatedData['destination']);
                $cityName = $city ? $city['city_name'] : 'Unknown City';

                // Format alamat lengkap
                $alamat = $validatedData['alamat'] . ', ' . $cityName . ', ' . $validatedData['province'];
            }
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
            'status' => 'Belum Dibayar',
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
            ->where('status', 'Belum Dibayar')
            ->with('detailPesanans.karya')
            ->first();

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false; // Development mode
        \Midtrans\Config::$isSanitized = true;   // Data sanitasi aktif
        \Midtrans\Config::$is3ds = true;         // 3DS aktif untuk kartu kredit

        // Daftar item yang akan dibeli
        $itemDetails = [];
        foreach ($pesanan->detailPesanans as $detail) {
            $itemDetails[] = [
                'id' => '', // Anda bisa menambahkan ID jika diperlukan
                'price' => $detail->price_karya,
                'quantity' => 1,
                'name' => $detail->karya->name,
            ];
        }

        // dd($pesanan->detailPesanans->first()->karya->name);
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
            'item_details' => $itemDetails,
        ];

        // dd($params);

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return view('landing.pesanan.pembayaran', compact('pesanan', 'snapToken'));
    }

    public function callback(Request $request, $trxId)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture') {
                // Temukan pesanan berdasarkan transaksi ID
                $order = Pesanan::where($trxId)->first();

                // Ubah status pesanan menjadi 'Dikemas'
                $order->update(['status' => 'Dikemas']);

                // Hapus karya-karya yang terkait dengan pesanan dari keranjang pengguna
                foreach ($order->karya as $karya) {
                    $karya->update([
                        'status' => 'Terjual'
                    ]);

                    // Hapus karya terkait dari keranjang pengguna yang melakukan checkout
                    $userId = $order->user_id;
                    $userKeranjang = Keranjang::where('user_id', $userId)
                        ->where('karya_id', $karya->id)
                        ->first();

                    // Hapus karya dari keranjang
                    if ($userKeranjang) {
                        $userKeranjang->delete();
                    }
                }
            } elseif (($request->transaction_status == 'cancel' && $request->payment_type == 'credit_card' && $request->fraud_status == 'deny')  ||
                $request->transaction_status == 'deny'  ||
                $request->transaction_status == 'pending'  ||
                $request->transaction_status == 'expired'
            ) {

                // Jika status transaksi cancel atau deny, ubah status pesanan menjadi 'Dibatalkan'
                $order = Pesanan::find($trxId)->where('status', 'Belum Dibayar')->first();
                if ($order) {
                    $order->update(['status' => 'Dibatalkan']);
                }
            }
        }

        // Redirect ke halaman riwayat pesanan
        return redirect()->route('pesanan.riwayat');
    }

    public function riwayatPesanan()
    {
        // Ambil parameter 'type' dari URL, jika ada
        $type = request('type');

        // Mulai query pesanan berdasarkan user yang login
        $pesananQuery = Pesanan::where('user_id', Auth::id())
            ->with('detailPesanans.karya')
            ->pencarian();

        // Jika ada filter 'type', gunakan scope untuk filter berdasarkan status pembayaran
        if ($type) {
            // Memanggil scope statusPembayaran
            $pesananQuery->statusPembayaran($type);
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

    public function konfirmasiSelesai($id)
    {
        // Cari pesanan berdasarkan ID
        $pesanan = Pesanan::findOrFail($id);

        // Pastikan hanya pesanan dengan status "Dikirim" yang bisa dikonfirmasi selesai
        if ($pesanan->status == 'Dikirim') {
            $pesanan->update(['status' => 'Selesai']);
        }

        // Redirect kembali ke halaman riwayat pesanan dengan pesan sukses
        return redirect()->route('pesanan.riwayat')->with('success', 'Pesanan berhasil dikonfirmasi selesai');
    }

    public function cekOngkir()
    {
        $response = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->get('https://api.rajaongkir.com/starter/city');

        $cities = $response['rajaongkir']['results'];
        $ongkir = $response['rajaongkir']['results'];

        return view('landing.pesanan.cekongkir', ['cities' => $cities, 'ongkir' => '']);
    }

    public function ongkirKiriman(Request $request)
    {
        $response = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->get('https://api.rajaongkir.com/starter/city');

        $responseCost = Http::withHeaders([
            'key' => 'ee887248ab9a52cdb808a833290bf396'
        ])->post('https://api.rajaongkir.com/starter/cost', [
            'origin' => $request->origin,
            'destination' => $request->destination,
            'weight' => $request->weight,
            'courier' => $request->courier,
        ]);

        $cities = $response['rajaongkir']['results'];
        $ongkir = $responseCost['rajaongkir'];

        dd($ongkir);

        return view('landing.pesanan.cekongkir', ['cities' => $cities, 'ongkir' => $ongkir]);
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
