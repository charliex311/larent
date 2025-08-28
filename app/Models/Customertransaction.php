<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customertransaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'invoice_id',
        'amount',
        'transaction_id',
        'deposithistory_id',
        'type',
        'status',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function deposit()
    {
        return $this->belongsTo(Deposithistory::class, 'deposithistory_id');
    }
}
