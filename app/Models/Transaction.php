<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    
    protected $guarded = [];

    // Relasi ke Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_topup_id');
    }

    // Relasi ke Wallet (One-to-One)
    public function ewallet()
    {
        return $this->belongsTo(EWallet::class, 'ewallet_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }
}
