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
        if ($search = request('search')) {
            if ($search == 'free') {
                $query->where('category', 'free');
            } else {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_event', 'like', '%' . $search . '%')
                        ->orWhere('start_date', 'like', '%' . $search . '%')
                        ->orWhere('end_date', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%');
                });
            }
        }
    }
}
