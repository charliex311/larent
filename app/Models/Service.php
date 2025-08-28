<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'unit',
        'price',
        'currency', 
        'tax',
        'tax_value',
        'total_price',
        'street',
        'postal_code',
        'city',
        'country',
        'box_code',
        'client_code',
        'deposit_code',
        'access_phone',
        'floor_number',
        'house_number',
        'status',
        'user_id',
        'secondarycontact_id',
        'square_weather',
        'room',
        'maximal_capacity_place',
        'wifi_name',
        'wifi_password',
        'balcony',
        'regularity',
        'speciality',
        'is_cleaning',
        'files',
    ];


    protected $dates = ['deleted_at'];
}
