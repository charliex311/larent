<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paymentmethod extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'details',
        'logo',
        'status'
    ];


    protected $dates = ['deleted_at'];
}
