<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emplyeetransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'joblist_id',
        'service_id',
        'withdraw_id',
        'amount',
        'type',
        'status',
    ];


    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function job()
    {
        return $this->belongsTo(Joblist::class, 'joblist_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
