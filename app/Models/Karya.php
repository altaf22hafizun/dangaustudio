<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karya extends Model
{
    use HasFactory;

    protected $fillable = [
        'seniman_id',
        'pameran_id',
        'name',
        'description',
        'price',
        'category',
        'image',
        'stock'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    // Relasi: Karya dimiliki oleh Seniman
    public function seniman()
    {
        return $this->belongsTo(Seniman::class);
    }

    // Relasi: Karya mungkin termasuk dalam Pameran
    public function pameran()
    {
        return $this->belongsTo(Pameran::class);
    }

    // Relasi: Karya memiliki banyak Transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
