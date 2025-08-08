<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingMethodFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'delivery_time',
        'is_active',
    ];

    public function orders() : HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function carts() : HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
