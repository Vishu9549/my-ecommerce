<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuotesItem extends Model
{
    use HasFactory;

     protected $fillable = [
        'quote_id',
        'product_id',
        'name',
        'sku',
        'price',
        'qty',
        'row_total',
        'custom_option',
    ]; 
    
    protected $casts = [
        'custom_option' => 'array',
    ];

    public function quote()
{
    return $this->belongsTo(Quote::class, 'quote_id'); // or change foreign key if needed
}
public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}

}
