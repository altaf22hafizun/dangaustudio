<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'karya_id',
        'tgl_transaksi',
        'jumlah',
        'price',
        'status_pembayaran',
        'metode_pengiriman',
        'proof',
        'trx_id'
    ];

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

    // Relasi: Transaksi dimiliki oleh Karya
  
}
