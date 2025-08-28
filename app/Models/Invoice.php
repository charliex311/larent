<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'billing_address',
        'invoice_number',
        'total_customer_price',
        'total_tax',
        'total_price',
        'currency',
        'date',
        'start_date',
        'end_date',
        'status',
        'generated_invoice'
    ];


    protected $casts = [
        'date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];


    public function jobs()
    {
        return $this->hasMany(Joblist::class);
    }
}
