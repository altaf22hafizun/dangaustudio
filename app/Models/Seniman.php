<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniman extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'bio',
    //     'telp',
    //     'medsos',
    //     'foto_profile'
    // ];

    protected $guarded = [];

    public function setNameSenimanAtributes($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    // Relasi: Seniman memiliki banyak Karya
    public function karyas()
    {
        return $this->hasMany(Karya::class);
    }
}
