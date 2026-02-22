<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable = [
        'departamento',
        'municipio',
        'puesto_votacion',
        'mesa',
        'zona',
        'direccion',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'mesa_id');
    }
}