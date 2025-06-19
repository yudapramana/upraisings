<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


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

    public static function boot()
    {
        parent::boot();

        static::creating(function ($trip) {
            $trip->trip_transaction_id = self::generateTransactionId();
        });
    }

    public static function generateTransactionId()
    {
        do {
            $randomNumber = mt_rand(1000000000, 9999999999); // 10 digit acak
            $transactionId = 'AT-' . $randomNumber;
        } while (self::where('trip_transaction_id', $transactionId)->exists());

        return $transactionId;
    }

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
