<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Seniman extends Model
{
    use HasFactory;

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

    public function scopePencarian(Builder $query): void
    {
        if (request('search')) {
            $search = request('search');

            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('medsos', 'like', '%' . $search . '%');
        }
    }
}
