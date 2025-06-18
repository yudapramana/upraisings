<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';

    protected $guarded = [];

    protected $casts = [
        'pickup_time' => 'datetime',
        'arrival_time' => 'datetime',
        'pickup_latitude' => 'float',
        'pickup_longitude' => 'float',
        'destination_latitude' => 'float',
        'destination_longitude' => 'float',
        'trip_fare' => 'float',
    ];

    /**
     * Relasi ke user (penumpang)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke transaksi (jika diperlukan)
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
