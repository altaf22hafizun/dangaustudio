<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniman extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'telp',
        'medsos',
        'foto_profile'
    ];


    // Relasi: Seniman memiliki banyak Karya
    public function karyas()
    {
        return $this->hasMany(Karya::class);
    }
}
