<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bill_id',
        'amount_paid',
        'payment_date',
        'payment_mode',
        'notes',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
