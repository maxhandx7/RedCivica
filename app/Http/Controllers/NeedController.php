<?php

namespace App\Http\Controllers;

use App\Constants\ActividadPlantillas;
use App\Models\Need;
use App\Http\Requests\StoreNeedRequest;
use App\Http\Requests\UpdateNeedRequest;
use App\Models\Actividad;
use App\Services\ActividadService;
use Illuminate\Http\Request;

class NeedController extends Controller
{
    public function __construct()
    {

         $this->middleware('auth')/* ->except(['form', 'store', 'checkCedula']) */ ;
        $this->middleware('role:admin')/* ->except(['form', 'store', 'checkCedula']) */ ;
    }
    public function index()
    {
        // Obtener las necesidades registradas por el usuario autenticado
        $needs = Need::orderBy('created_at', 'desc')
            ->get();

        return view('admin.need.index', compact('needs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string'
        ]);

        Need::create([
            'registrado_por' => auth()->id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente'
        ]);

        ActividadService::registrarNecesidad(
            ActividadPlantillas::NUEVA_NECESIDAD,
            auth()->id()
        );

        return redirect()->back()->with('success', 'Necesidad registrada con éxito');

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:pendiente,en proceso,resuelta'
        ]);

        $need = Need::where('id', $id)
            ->firstOrFail();

        $need->update($request->only(['titulo', 'descripcion', 'estado']));

        if ($request->estado === 'resuelta') {
            $actividad = ActividadPlantillas::NECESIDAD_UPDATE;
            $actividad['accion'] = sprintf($actividad['accion'], $need->titulo);
            ActividadService::registrarNecesidad(
                $actividad,
                auth()->id(),   
                $need->registrado_por,
            );

            return redirect()->back()->with('success', 'Necesidad actualizada');
        }
    }

    public function destroy($id)
    {
        $need = Need::where('id', $id)
            ->firstOrFail();

        $need->delete();

        return redirect()->back()->with('success', 'Necesidad eliminada con éxito');
    }
}
