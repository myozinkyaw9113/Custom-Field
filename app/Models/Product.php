<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'normal_prize',
        'discount_prize',
        'is_popular',
        'is_active',
        'serial_number',
        'image'
    ];

    protected $casts = [
        'image' => 'array',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];
}
