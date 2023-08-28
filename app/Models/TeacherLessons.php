<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLessons extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'lesson_id'
    ];
}
