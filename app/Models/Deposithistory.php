<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposithistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'payment_details',
        'attachment',
        'amount',
        'notes',
        'status'
    ];
}
