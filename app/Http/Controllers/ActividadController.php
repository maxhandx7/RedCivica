<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Http\Requests\StoreActividadRequest;
use App\Http\Requests\UpdateActividadRequest;

class ActividadController extends Controller
{
   public function index()
    {
        $actividades = Actividad::with(['actor', 'afectado'])
            ->latest()
            ->take(30)
            ->get();

        return view('admin.actividad.index', compact('actividades'));
    }
}
