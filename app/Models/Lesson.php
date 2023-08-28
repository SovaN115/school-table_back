<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    public function teachers() {
        return $this->belongsToMany(Teacher::class, 'teacher_lessons');
    }

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    protected $fillable = [
        'template_id',
        'name',
        'teacher_id'
    ];
}
