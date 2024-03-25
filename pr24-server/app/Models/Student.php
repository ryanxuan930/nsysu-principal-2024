<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $primaryKey = 'student_id';

    protected $fillable = [
        'name',
        'email',
        'student_no',
        'phone',
        'ip',
        'check_in',
        'check_out',
        'area',
        'row',
        'no',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    protected $hidden = [
        'ip',
    ];
}
