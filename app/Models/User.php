<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'flat_no',
        'phone',
        'milk_type_id',
        'default_qty',
        'rate',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function milkTypes()
    {
        return $this->belongsToMany(MilkType::class, 'customer_milk_types')
            ->withPivot(['default_qty', 'rate'])
            ->withTimestamps();
    }

    public function bills()
    {
        $this->hasMany(Bill::class,'customer_id');
    }

    public function deliveries()
    {
        $this->hasMany(Delivery::class,'customer_id');
    }
}
