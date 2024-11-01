<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'trx_id',
        'tgl_transaksi',
        'proof',
        'status_pembayaran',
        'metode_pengiriman',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public static function generateUniqueTransaction()
    {
        $prefix = 'DNGSTD';
        $length = 16; // Total panjang ID yang diinginkan
        $prefixLength = strlen($prefix);
        $uuidLength = $length - $prefixLength;

        do {
            // Generate UUID
            $uuid = Str::uuid()->toString();

            // Ambil substring UUID yang cukup untuk mencapai panjang total yang diinginkan
            $randomString = $prefix . substr($uuid, 0, $uuidLength);
        } while (self::where('trx_id', $randomString)->exists());

        return $randomString;
    }
}
