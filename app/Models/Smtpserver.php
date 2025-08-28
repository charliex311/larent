<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smtpserver extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'hostname',
        'username',
        'password',
        'port',
        'encryption',
        'hourly_limit',
        'from_address',
        'status'
    ];
}
