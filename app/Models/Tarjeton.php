<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tarjeton extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidato_id',
        'nombre',
        'total_opciones',
        'instruccion',
        'secciones',
        'configuracion',
        'activo'
    ];

    protected $casts = [
        'secciones' => 'array',
        'configuracion' => 'array',
        'activo' => 'boolean',
        'total_opciones' => 'integer'
    ];

    // Relaciones
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    // Métodos de ayuda
    public function getTotalSeccionesAttribute()
    {
        return count($this->secciones ?? []);
    }

    public function getOpcionesPorSeccionAttribute()
    {
        $opciones = [];
        foreach ($this->secciones as $seccion) {
            $opciones[] = [
                'nombre' => $seccion['nombre'],
                'rango' => $seccion['rango'],
                'total' => count($seccion['rango'])
            ];
        }
        return $opciones;
    }
}