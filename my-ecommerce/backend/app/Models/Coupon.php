<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'coupon_code',
        'status',
        'valid_from',
        'valid_to',
        'discount_amount',
    ];


        public function quote()
{
    return $this->belongsTo(Quote::class, 'quote_id'); // or change foreign key if needed
}


}
