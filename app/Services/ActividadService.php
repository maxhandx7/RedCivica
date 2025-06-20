<?php

namespace App\Services;

use App\Models\Actividad;
use Illuminate\Support\Facades\Auth;

class ActividadService
{
    public static function registrar(array $plantilla, $afectado_id = null, $actor_id = null)
    {
        return Actividad::create([
            'titulo' => $plantilla['titulo'],
            'accion' => $plantilla['accion'],
            'icono'  => $plantilla['icono'] ?? null,
            'actor_id' => Auth::id() ?? $actor_id,
            'afectado_id' => $afectado_id,
        ]);
    }
}
