<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campaña',
        'objetivo',
        'fuente',
        'medio',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
