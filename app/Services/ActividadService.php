<?php

namespace App\Services;

use App\Mail\notificationMail;
use App\Models\Actividad;
use App\Models\Need;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ActividadService
{
    public static function registrar(array $plantilla, $afectado_id = null, $actor_id = null)
    {
        $actividad = Actividad::create([
            'titulo' => $plantilla['titulo'],
            'accion' => $plantilla['accion'],
            'icono'  => $plantilla['icono'] ?? null,
            'actor_id' => Auth::id() ?? $actor_id,
            'afectado_id' => $afectado_id,
        ]); 
    
        Mail::to("agenda.alancarabali@gmail.com")->send(new notificationMail($actividad));

        return $actividad;
    }

    public static function registrarNecesidad( array $plantilla,  $actor_id = null, $afectado_id = null)
    {
         $actividad = Actividad::create([
            'titulo' => $plantilla['titulo'],
            'accion' => $plantilla['accion'],
            'icono'  => $plantilla['icono'] ?? null,
            'actor_id' => Auth::id() ?? $actor_id,
            'afectado_id' => $afectado_id ?? null,
        ]); 

        Mail::to("agenda.alancarabali@gmail.com")->send(new notificationMail($actividad));

        return $actividad;
    }
}
