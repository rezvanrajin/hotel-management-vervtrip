<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'price',
        'capacity',
        'size',
        'bed_type',
        'status',
        'amenities',
        'description',
        'images'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'size' => 'decimal:2'
    ];
}
