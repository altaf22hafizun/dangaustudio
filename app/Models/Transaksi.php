<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'trx'
    ];

    // Relasi: Transaksi dimiliki oleh Karya
    public function karya()
    {
        return $this->belongsTo(Karya::class);
    }
}
