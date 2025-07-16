<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Need extends Model
{
    use HasFactory;


    protected $fillable = [
        'referido_id',
        'registrado_por',
        'titulo',
        'descripcion',
        'estado',
    ];

    public function referido()
    {
        return $this->belongsTo(User::class, 'referido_id');
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
