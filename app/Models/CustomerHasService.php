<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerHasService extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'service_id',
    ];

    function customer() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function service() {
        return $this->hasOne(Service::class, 'id', 'service_id');
    }
}
