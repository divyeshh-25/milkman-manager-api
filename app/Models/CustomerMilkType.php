<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerMilkType extends Model
{
    protected $fillable = [
        'user_id',
        'milk_type_id',
        'default_qty',
        'rate',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function milkType()
    {
        return $this->belongsTo(MilkType::class);
    }
}
