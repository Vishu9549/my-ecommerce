<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'is_featured',
        'sku',
        'qty',
        'stock_status',
        'weight',
        'price',
        'special_price',
        'special_price_from',
        'special_price_to',
        'url_key',
        'short_description',
        'description',
        'meta_tag',
        'meta_title',
        'meta_description',
        'image',
        'thumbnail_image'
    ];
    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function categories()
    {
        return $this->belongsToMany(categories::class, 'categories_product', 'product_id', 'category_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute_value')
            ->withPivot('value');
    }

    public function attributeValues()
    {
        return $this->belongsToMany(AttributeValue::class, 'attribute_product_value')
            ->with('attribute')
            ->withTimestamps();
    }

    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related', 'product_id', 'related_product_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? url('uploads/product/' . $this->image) : null;
    }

}
