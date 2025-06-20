<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Requests\StoreActividadRequest;
use App\Http\Requests\UpdateActividadRequest;

class ActividadController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $actividades = Actividad::with(['actor', 'afectado'])
            ->latest()
            ->take(30)
            ->get();
        }
        
        $actividades = Actividad::with(['actor', 'afectado'])
            ->where('actor_id', auth()->id())
            ->orWhere('afectado_id', auth()->id())
            ->latest()
            ->take(30)
            ->get();

        return view('admin.actividad.index', compact('actividades'));
    }

    public function marcarComoLeidas()
    {
        Actividad::where('actor_id', auth()->id())
            ->where('leida', false)
            ->update(['leida' => true]);

        return back();
    }
}
