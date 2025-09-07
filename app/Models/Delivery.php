<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'customer_id',
        'milk_type_id',
        'date',
        'delivered_qty',
        'change_qty',
        'notes'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function milkType()
    {
        $this->belongsTo(MilkType::class);
    }

}
