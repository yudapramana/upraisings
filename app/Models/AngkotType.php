<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngkotType extends Model
{
    use HasFactory;

    protected $fillable = [
        'route_number',
        'route_name',
        'color',
    ];

    // Relasi ke kendaraan yang menggunakan tipe ini
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
