<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidato extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'apellido',
        'alias',
        'cargo',
        'circunscripcion',
        'partido',
        'lema',
        'color_principal',
        'imagen',
        'biografia',
        'fecha_eleccion',
        'activo',
        'orden'
    ];

    protected $casts = [
        'fecha_eleccion' => 'date',
        'activo' => 'boolean',
        'orden' => 'integer'
    ];

    // Relaciones
    public function propuestas()
    {
        return $this->hasMany(Propuesta::class)->orderBy('orden');
    }

    public function tarjetones()
    {
        return $this->hasMany(Tarjeton::class);
    }

    public function metricas()
    {
        return $this->hasMany(Metrica::class);
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorCargo($query, $cargo)
    {
        return $query->where('cargo', $cargo);
    }

    public function scopeConPropuestas($query)
    {
        return $query->with('propuestas');
    }

    // Métodos de ayuda
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->nombre} {$this->apellido}");
    }

    public function getInicialesAttribute()
    {
        return strtoupper(substr($this->nombre, 0, 1) . substr($this->apellido, 0, 1));
    }

    public function getTotalPropuestasAttribute()
    {
        return $this->propuestas()->count();
    }

    public function getPropuestasPorCategoriaAttribute()
    {
        return $this->propuestas()
            ->selectRaw('categoria, count(*) as total')
            ->groupBy('categoria')
            ->get()
            ->pluck('total', 'categoria');
    }
}