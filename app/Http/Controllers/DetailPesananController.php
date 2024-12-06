<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            ->with('karya', 'karya.seniman')  // Mengambil data karya dan seniman
            ->get();

        // Pastikan tidak ada pesanan yang kosong atau tidak valid
        if ($pesanans->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pesanan yang Anda pilih tidak ditemukan.');
        }

        // Redirect ke halaman pembayaran dengan data pesanan
        return view('landing.pesanan.index', ['pesanans' => $pesanans]);
    }

    public function checkout(Request $request)
    {
        $request->request->add(['status_pembayaran' => 'Pending']);

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
}
