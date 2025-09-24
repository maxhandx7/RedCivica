<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_id',
        'question_text',
        'question_type',
        'options',
        'is_required',
        'department_id' 
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean'
    ];


   

}
