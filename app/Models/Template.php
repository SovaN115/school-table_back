<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    protected $table = 'template';
    protected $fillable = [
        'days',
        'lessons',
        'name',
        'table_id',
        'is_selected'
    ];
}
