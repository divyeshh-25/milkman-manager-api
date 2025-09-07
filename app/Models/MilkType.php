<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MilkType extends Model
{
    protected $fillable = [
        'name',
        'default_rate'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function billItems()
    {
        return $this->hasMany(BillItem::class);
    }
}
