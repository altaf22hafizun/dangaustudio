<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function karya()
    {
        return $this->belongsTo(Karya::class);
    }

    // public static function generateUniqueTransaction()
    // {
    //     $prefix = 'DNGSTD';
    //     $length = 16; // Total panjang ID yang diinginkan
    //     $prefixLength = strlen($prefix);
    //     $uuidLength = $length - $prefixLength;

    //     do {
    //         // Generate UUID
    //         $uuid = Str::uuid()->toString();

    //         // Ambil substring UUID yang cukup untuk mencapai panjang total yang diinginkan
    //         $randomString = $prefix . substr($uuid, 0, $uuidLength);
    //     } while (self::where('trx_id', $randomString)->exists());

    //     return $randomString;
    // }
    // public static function generateUniqueTransaction()
    // {
    //     $prefix = 'DNGSTD';
    //     $uuid = Str::uuid()->toString(); // Generate UUID
    //     $randomString = $prefix . substr($uuid, 0, 12); // Gunakan 12 karakter pertama dari UUID

    //     // Cek apakah trx_id sudah ada
    //     while (self::where('trx_id', $randomString)->exists()) {
    //         $randomString = $prefix . substr(Str::uuid()->toString(), 0, 12); // Generate ulang jika sudah ada
    //     }

    //     return $randomString;
    // }


}
