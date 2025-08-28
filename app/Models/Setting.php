<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company',
        'company_email',
        'website',
        'company_address',
        'invoice_prefix',
        'invoice_number',
        'invoice_text',
        'currency',
        'hourly_rate',
        'bank',
        'bic',
        'iban',
        'ust_idnr',
        'business_number',
        'fiscal_number',
        'note_for_email',
        'email_premissions'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
