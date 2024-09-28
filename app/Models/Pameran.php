<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pameran extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_pameran',
        'description',
        'category',
        'start_date',
        'end_date',
        'image',
        'status_publikasi'
    ];

    // Relasi: Pameran memiliki banyak Karya
    public function karyas()
    {
        return $this->hasMany(Karya::class);
    }
}
