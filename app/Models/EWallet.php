<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EWallet extends Model
{
    use HasFactory;

    protected $table = 'ewallets';
    
    protected $guard = [];

    protected $fillable = ['user_id', 'qrcode_string', 'qrcode_url'];


    // Relasi ke Bank
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'ewallet_id');
    }
}
