<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $fillable = [
        'bill_id',
        'milk_type_id',
        'total_liters',
        'rate',
        'amount'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function milkType()
    {
        return $this->belongsTo(MilkType::class);
    }
}
