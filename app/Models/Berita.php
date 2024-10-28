<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function setNameBeritaAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }
    public function scopePencarian(Builder $query): void
    {
        if (request('search')) {
            $search = request('search');

            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('tgl', 'like', '%' . $search . '%')
                ->orWhere('sumber_berita', 'like', '%' . $search . '%')
                ->orWhere('label_berita', 'like', '%' . $search . '%');
        }
    }
}
