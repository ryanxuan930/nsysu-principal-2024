<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    protected $primaryKey = 'seat_id';

    protected $fillable = [
        'area',
        'row',
        'no',
        'priority',
        'is_occupied',
        'is_reserved',
    ];

    protected $casts = [
        'is_occupied' => 'boolean',
        'is_reserved' => 'boolean',
    ];
}
