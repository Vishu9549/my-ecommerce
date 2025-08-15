<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'status',
        'show_in_menu',
        'short_description',
        'description',
        'url_key',
        'meta_title',
        'meta_tag',
        'meta_description',
        'image',
    ];

    protected static function booted()
    {
        static::creating(function ($categories) {
            if (empty($categories->slug)) {
                $categories->slug = Str::slug($categories->name);
            }
        });
    }

    // 🔁 Relationship: Parent Category
    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    // 🔁 Relationship: Child Categories
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }

    // 🔁 Many-to-Many: Products
   
    // 🖼️ Image URL accessor
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/categories/' . $this->image) : null;
    }
    public function products()
{
    return $this->belongsToMany(Product::class, 'categories_product', 'category_id', 'product_id');
}

}
