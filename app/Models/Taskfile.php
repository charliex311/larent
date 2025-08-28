<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'joblist_id',
        'task_id',
        'caption',
        'filename'
    ];
}
