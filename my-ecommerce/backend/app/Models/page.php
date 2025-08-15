<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class page extends Model
{
    use HasFactory;
       protected $fillable = [
        'title',
        'heading',
        'ordering',
        'url_key',
        'status',
        'description',
         'image',
    ];
}
