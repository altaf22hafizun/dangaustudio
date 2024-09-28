<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Mutator untuk mengubah setiap awal kata menjadi huruf kapital
    public function setNameEventAttribute($value)
    {
        $this->attributes['name_event'] = ucwords(strtolower($value));
    }
}
