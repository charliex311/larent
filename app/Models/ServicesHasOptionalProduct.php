<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesHasOptionalProduct extends Model
{
    use HasFactory;

    protected $fillable = ['service_id', 'optional_product_id'];

    function product() {
        return $this->hasOne(Optionalproduct::class, 'id', 'optional_product_id');
    }
}
