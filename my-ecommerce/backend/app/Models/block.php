<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'heading',
        'ordering',
        'identifier',
        'status',
        'image',
        'image_1',
        'image_2',
        'image_3',
        'description',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'image' => 'array',
    ];
}
