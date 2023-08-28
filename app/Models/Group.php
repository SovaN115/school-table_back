<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'template_id',
        'name',
        'number_of_students'
    ];
}
