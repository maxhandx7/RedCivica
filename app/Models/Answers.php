<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'numero_documento',
        'email',
        'pais',
        'departamento',
        'ciudad',
        'respuestas',
        'user_id',
    ];

    protected $casts = [
        'respuestas' => 'array', // para acceder como array en Eloquent
    ];

    // Relación opcional con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getLocationAttribute()
    {
        return "{$this->ciudad}, {$this->departamento}, {$this->pais}";
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('nombre', 'like', "%{$search}%")
            ->orWhere('apellido', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
    }
}
