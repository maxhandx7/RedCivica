<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Referencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaña_id',
        'objetivo',
        'fuente',
        'medio',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usuariosRegistrados()
{
    return $this->hasMany(User::class, 'referencia_id');
}


    

    public function campaña()
    {
        return $this->belongsTo(Campaña::class);
    }
}
