<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Propuesta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidato_id',
        'titulo',
        'descripcion',
        'categoria',
        'icono',
        'color',
        'orden',
        'destacada',
        'metas',
        'indicadores'
    ];

    protected $casts = [
        'destacada' => 'boolean',
        'orden' => 'integer',
        'metas' => 'array',
        'indicadores' => 'array'
    ];

    // Relaciones
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    // Scopes
    public function scopeDestacadas($query)
    {
        return $query->where('destacada', true);
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeOrdenadas($query)
    {
        return $query->orderBy('orden')->orderBy('id');
    }

    // Métodos de ayuda
    public function getCategoriaFormateadaAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->categoria));
    }

    public function getColorClaroAttribute()
    {
        return $this->color . '20'; // Agrega transparencia
    }
}