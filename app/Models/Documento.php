<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'candidato_id',
        'nombre',
        'tipo',
        'archivo',
        'formato',
        'tamano',
        'descripcion',
        'publico'
    ];

    protected $casts = [
        'publico' => 'boolean',
        'tamano' => 'integer'
    ];

    // Relaciones
    public function candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    // Scopes
    public function scopePublicos($query)
    {
        return $query->where('publico', true);
    }

    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    // Métodos de ayuda
    public function getRutaArchivoAttribute()
    {
        return asset('storage/documentos/' . $this->archivo);
    }

    public function getTamanoFormateadoAttribute()
    {
        if ($this->tamano >= 1048576) {
            return round($this->tamano / 1048576, 2) . ' MB';
        } elseif ($this->tamano >= 1024) {
            return round($this->tamano / 1024, 2) . ' KB';
        }
        return $this->tamano . ' bytes';
    }
}