<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metrica extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidato_id',
        'tipo_metrica',
        'nombre',
        'valor',
        'unidad',
        'fecha_medicion',
        'metadata'
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'fecha_medicion' => 'date',
        'metadata' => 'array'
    ];

    // Relaciones
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    // Scopes
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo_metrica', $tipo);
    }

    public function scopeRecientes($query, $dias = 30)
    {
        return $query->where('fecha_medicion', '>=', now()->subDays($dias));
    }
}