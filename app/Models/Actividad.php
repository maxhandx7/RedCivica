<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

     protected $fillable = [
        'titulo',
        'icono',
        'actor_id',
        'accion',
        'afectado_id',
    ];

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    public function afectado()
    {
        return $this->belongsTo(User::class, 'afectado_id');
    }
    
}
