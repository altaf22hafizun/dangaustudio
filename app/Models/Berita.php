<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setNameBeritaAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    public function setPenulisAttribute($value)
    {
        $this->attributes['penulis'] = ucwords(strtolower($value));
    }
}
