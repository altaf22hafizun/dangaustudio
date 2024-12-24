<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DetailController extends Controller
{
    public function callback(Request $request)
    {
         // Ambil server key dari konfigurasi Midtrans
        $serverKey = config('midtrans.server_key');
        // Buat hash untuk memverifikasi signature
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed == $request->signature_key) {
            // Jika status transaksi capture atau settlement
            if (($request->transaction_status == 'capture' && $request->payment_type == 'credit_card' && $request->fraud_status == 'accept') || $request->transaction_status == 'settlement') {
                $order = Pesanan::where('trx_id', $request->order_id)->first();
                // Jika ditemukan donasi, update status menjadi Pembayaran Berhasil
                if ($order) {
                    $order->update(['status' => 'Dikemas']);
                }
            } elseif (($request->transaction_status == 'cancel' && $request->payment_type == 'credit_card' && $request->fraud_status == 'deny')  || $request->transaction_status == 'deny'  || $request->transaction_status == 'pending'  || $request->transaction_status == 'expired') {
                // Jika status transaksi cancel
                $order = Pesanan::where('trx_id', $request->order_id)->where('status', 'Belum Dibayar')->first();
                // Jika ditemukan donasi dan status masih Menunggu Pembayaran, update status menjadi Pembayaran Dibatalkan
                if ($order) {
                    $order->update(['status' => 'Dibatalkan']);
                }
            }
        }

        // Redirect ke halaman riwayat pesanan
        return redirect()->route('pesanan.riwayat');
    }
}
