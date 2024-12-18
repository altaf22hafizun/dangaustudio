<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopePencarian(Builder $query): void
    {
        if ($search = request('search')) {
            $query->where('trx_id', 'like', '%' . $search . '%')
                // Pencarian berdasarkan nama karya melalui relasi
                ->orWhereHas('detailPesanans.karya', function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                });
        }
    }

    // Scope untuk filter url status pembayaran
    public function scopeStatusPembayaran(Builder $query, $type): void
    {
        switch ($type) {
            case '6':
                // Filter berdasarkan status pembayaran "Menunggu Pembayaran" dan "Pengiriman / Belum Dibayar"
                $query->whereIn('status', 'Belum Dibayar');
                break;

            case '2':
                // Filter berdasarkan status pembayaran "Diterima Pelanggan / Selesai"
                $query->where('status', 'Selesai');
                break;

            case '4':
                // Filter berdasarkan status pembayaran "Pembayaran Diterima, Sedang Diproses untuk Pengiriman'/Dikemas"
                $query->where('status', 'Dikemas');
                break;

            case '9':
                // Filter berdasarkan status pembayaran "Pengiriman Dan Pembayaran Dibatalkan / Dibatalkan"
                $query->where('status', 'Dibatalkan');
                break;

            case '7':
                // Filter berdasarkan status pembayaran "Dikirim / Paket Dalam Perjalanan"
                $query->where('status', 'Dikirim');
                break;
        }
    }
}
