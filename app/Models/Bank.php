<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['bank_name', 'account_number', 'account_holder'];

    // Relasi ke Transaction (one-to-many)
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'bank_topup_id');
    }
}