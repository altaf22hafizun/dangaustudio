<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function scopePencarian(Builder $query): void
    {
        if (request('search')) {
            $search = request('search');

            $query->where('name_pameran', 'like', '%' . $search . '%')
                ->orWhere('start_date', 'like', '%' . $search . '%')
                ->orWhere('end_date', 'like', '%' . $search . '%');
        }
    }
}
