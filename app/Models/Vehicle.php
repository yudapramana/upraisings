<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke User (pemilik kendaraan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke AngkotType (tipe trayek angkot)
    public function angkotType()
    {
        return $this->belongsTo(AngkotType::class);
    }
}
