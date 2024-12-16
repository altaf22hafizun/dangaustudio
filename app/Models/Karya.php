<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Karya extends Model
{
    use HasFactory;

    protected $fillable = [
        'seniman_id',
        'pameran_id',
        'name',
        'deskripsi',
        'price',
        // 'category',
        'medium',
        'size',
        'tahun',
        'image',
        'stock',
        'slug'
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
    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    // public function scopePencarian(Builder $query): void
    // {
    //     if (request('search')) {
    //         $search = request('search');

    //         $query->where('name', 'like', '%' . $search . '%')
    //             ->orWhere('price', 'like', '%' . $search . '%')
    //             ->orWhere('medium', 'like', '%' . $search . '%')
    //             ->orWhere('tahun', 'like', '%' . $search . '%')
    //             ->orWhereHas('seniman', function ($q) use ($search) {
    //                 $q->where('name', 'like', '%' . $search . '%');
    //             });
    //     }
    // }

    public function scopePencarian(Builder $query): void
    {
        // Filter berdasarkan medium yang dipilih
        if ($medium = request('medium')) {
            $query->where('medium', $medium);
        }

        // Filter berdasarkan tahun yang dipilih
        if ($tahun = request('tahun')) {
            $query->where('tahun', $tahun);
        }
    }
}
