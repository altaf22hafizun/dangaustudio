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
        'start_date',
        'end_date',
        'image',
        'status_publikasi',
        'slug',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name_pameran'] = ucwords(strtolower($value));
    }

    // Relasi: Pameran memiliki banyak Karya
    public function karyas()
    {
        return $this->hasMany(Karya::class);
    }
}
