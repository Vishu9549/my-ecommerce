<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_name',
        'name_key',
        'is_variant',
        'status',
    ];

    protected $casts = [
        'is_variant' => 'boolean',
    ];

    // 🔁 One-to-Many Relationship: Attribute has many Values
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
   

}
