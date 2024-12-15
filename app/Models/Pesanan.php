<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pesanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function karya()
    {
        return $this->belongsTo(Karya::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public static function generateUniqueTransaction()
    {
        $prefix = 'DNGSTD';
        $uuid = Str::uuid()->toString(); // Generate UUID
        $randomString = $prefix . substr($uuid, 0, 12); // Gunakan 12 karakter pertama dari UUID

        // Cek apakah trx_id sudah ada
        // while (self::where('trx_id', $randomString)->exists()) {
        //     $randomString = $prefix . substr(Str::uuid()->toString(), 0, 12); // Generate ulang jika sudah ada
        // }

        return $randomString;
    }

    public function setAlamatAttribute($value)
    {
        $this->attributes['alamat'] = ucwords(strtolower($value));
    }
}
