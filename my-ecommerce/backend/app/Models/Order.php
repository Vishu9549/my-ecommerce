<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_increment_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'address_2',
        'city',
        'state',
        'country',
        'pincode',
        'subtotal',
        'coupon',
        'coupon_discount',
        'shipping_cost',
        'total',
        'payment_method',
        'shipping_method',
    ];

    public function items()
{
    return $this->hasMany(OrderItem::class); 
    // adjust OrderItem::class to your actual order item model
}

public function addresses()
{
    return $this->hasMany(OrderAddresse::class, 'order_id');
}

}
