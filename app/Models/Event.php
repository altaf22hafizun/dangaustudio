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
        $this->attributes['nama_event'] = ucwords(strtolower($value));
    }
    public function setLocationEventAttribute($value)
    {
        $this->attributes['location'] = ucwords(strtolower($value));
    }
    public function setCategoryEventAttribute($value)
    {
        $this->attributes['category'] = ucwords(strtolower($value));
    }
}
