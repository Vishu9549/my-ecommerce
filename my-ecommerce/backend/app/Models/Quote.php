<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
  use HasFactory;

  protected $fillable = [
        'cart_id',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'pincode',
        'subtotal',
        'coupon',
        'coupon_discount',
        'total',
    ];


    public function items()
    {
        return $this->hasMany(QuotesItem::class, 'quote_id');
    }

   

}
