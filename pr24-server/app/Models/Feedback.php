<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';

    protected $fillable = [
        'student_id',
        'identity',
        'college',
        'grade',
        'q1_score',
        'q1_comment',
        'q2_score',
        'q2_comment',
        'q3_comment',
        'q4_score',
        'q4_comment',
        'q5_comment',
        'q6_comment',
    ];

    protected $casts = [
        'q1_score' => 'integer',
        'q2_score' => 'integer',
        'q4_score' => 'integer',
    ];
}
