<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'transaction_id',
        'amount',
        'payment_details',
        'type',
        'status',
    ];

    public function transactions()
    {
        return $this->hasMany(Emplyeetransaction::class);
    }
}
