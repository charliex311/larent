<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'joblist_id',
        'start_time',
        'start_latitude',
        'start_longitude',
        'end_time',
        'end_latitude',
        'end_longitude'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function customer()
    {
        // code here
    }

    public function job()
    {
        // code here
    }
}
