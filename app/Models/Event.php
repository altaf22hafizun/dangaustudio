<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    public function scopePencarian(Builder $query): void
    {

        // Pencarian berdasarkan kategori yang dipilih
        if ($category = request('category')) {
            $query->where('category', $category); // Mencocokkan kategori dari kolom 'category' di tabel events
        }
    }
}
