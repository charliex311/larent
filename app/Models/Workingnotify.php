<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workingnotify extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'invoice_id',
        'joblist_id'
    ];
}
