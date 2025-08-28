<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use HasRoles;
    
    protected $fillable = [
        'photo',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'customer_type',
        'date_of_birth',
        'street',
        'postal_code',
        'city',
        'country',
        'nationality',
        'pop_id',
        'block_reason'
    ];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];
    
    protected $casts = [
        'date_of_birth' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }


    public function customertransactions()
    {
        return $this->hasMany(Customertransaction::class);
    }
}
