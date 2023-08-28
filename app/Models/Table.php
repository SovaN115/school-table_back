<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $table = 'school_table';

    protected $fillable = [
        'template_id',
        'day_id',
        'call_id',
        'lesson_id',
        'class_id',
        'cabinet_id',
        'teacher_id'
    ];
}
