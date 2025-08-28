<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joblist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_id',
        'checkin',
        'checkout',
        'job_date',
        'cancel_date',
        'total_task_hour',
        'currency',
        'hourly_rate',
        'recurrence_type',
        'job_status',
        'job_notes',
        'journals',
        'paid_status',
        'optional_product',
        'employee_id',
        'secondarycontact_id',
        'employee_message',
        'service_id',
        'job_address',
        'number_of_people',
        'code_from_the_door',
        'invoice_created',
        'service_price',
        'employee_hours',
        'employee_price',
        'customer_hours',
        'customer_price',
        'total_price',
    ];


    protected $casts = [
        'checkin' => 'datetime',
        'checkout' => 'datetime',
        'job_date' => 'datetime',
        'cancel_date' => 'datetime',
    ];


    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }


    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id')->withTrashed();
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id')->withTrashed();
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskfiles()
    {
        return $this->hasMany(Taskfile::class);
    }
}
