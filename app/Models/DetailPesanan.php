<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
}
