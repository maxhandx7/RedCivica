<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\Propuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropuestaController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth')/* ->except(['form', 'store', 'checkCedula']) */ ;
        $this->middleware('role:admin')/* ->except(['form', 'store', 'checkCedula']) */ ;
    }
    public function index(Candidato $candidato)
    {
        $propuestas = $candidato->propuestas()
            ->orderBy('orden')
            ->get();

        $categorias = [
            'seguridad' => 'Seguridad',
            'educacion' => 'Educación',
            'economia' => 'Economía',
            'salud' => 'Salud',
            'social' => 'Social',
            'justicia' => 'Justicia',
            'medio_ambiente' => 'Medio Ambiente',
            'infraestructura' => 'Infraestructura',
            'transparencia' => 'Transparencia',
            'otros' => 'Otros'
        ];

        $iconos = [
            'fas fa-shield-alt' => 'Seguridad',
            'fas fa-graduation-cap' => 'Educación',
            'fas fa-chart-line' => 'Economía',
            'fas fa-heartbeat' => 'Salud',
            'fas fa-hands-helping' => 'Social',
            'fas fa-balance-scale' => 'Justicia',
            'fas fa-leaf' => 'Medio Ambiente',
            'fas fa-road' => 'Infraestructura',
            'fas fa-eye' => 'Transparencia',
            'fas fa-bullhorn' => 'General'
        ];

        return view('admin.propuestas.index', compact('candidato', 'propuestas', 'categorias', 'iconos'));
    }

    public function create(Candidato $candidato)
    {
        $categorias = [
            'seguridad' => 'Seguridad',
            'educacion' => 'Educación',
            'economia' => 'Economía',
            'salud' => 'Salud',
            'social' => 'Social',
            'justicia' => 'Justicia',
            'medio_ambiente' => 'Medio Ambiente',
            'infraestructura' => 'Infraestructura',
            'transparencia' => 'Transparencia',
            'otros' => 'Otros'
        ];

        $iconos = [
            'fas fa-shield-alt' => 'Seguridad',
            'fas fa-graduation-cap' => 'Educación',
            'fas fa-chart-line' => 'Economía',
            'fas fa-heartbeat' => 'Salud',
            'fas fa-hands-helping' => 'Social',
            'fas fa-balance-scale' => 'Justicia',
            'fas fa-leaf' => 'Medio Ambiente',
            'fas fa-road' => 'Infraestructura',
            'fas fa-eye' => 'Transparencia',
            'fas fa-bullhorn' => 'General'
        ];

        return view('admin.propuestas.create', compact('candidato', 'categorias', 'iconos'));
    }

    public function store(Request $request, Candidato $candidato)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'categoria' => 'required|in:seguridad,educacion,economia,salud,social,justicia,medio_ambiente,infraestructura,transparencia,otros',
            'icono' => 'required|string|max:50',
            'color' => 'required|string|size:7',
            'orden' => 'nullable|integer',
            'destacada' => 'boolean',
            'metas' => 'nullable|array',
            'indicadores' => 'nullable|array'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['candidato_id'] = $candidato->id;
            
            // Si no se especifica orden, se coloca al final
            if (!isset($data['orden'])) {
                $ultimoOrden = $candidato->propuestas()->max('orden') ?? 0;
                $data['orden'] = $ultimoOrden + 1;
            }

            $propuesta = Propuesta::create($data);

            DB::commit();

            return redirect()->route('admin.candidatos.propuestas.index', $candidato)
                ->with('success', 'Propuesta creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear la propuesta: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Candidato $candidato, Propuesta $propuesta)
    {
        if ($propuesta->candidato_id !== $candidato->id) {
            abort(404);
        }

        $categorias = [
            'seguridad' => 'Seguridad',
            'educacion' => 'Educación',
            'economia' => 'Economía',
            'salud' => 'Salud',
            'social' => 'Social',
            'justicia' => 'Justicia',
            'medio_ambiente' => 'Medio Ambiente',
            'infraestructura' => 'Infraestructura',
            'transparencia' => 'Transparencia',
            'otros' => 'Otros'
        ];

        $iconos = [
            'fas fa-shield-alt' => 'Seguridad',
            'fas fa-graduation-cap' => 'Educación',
            'fas fa-chart-line' => 'Economía',
            'fas fa-heartbeat' => 'Salud',
            'fas fa-hands-helping' => 'Social',
            'fas fa-balance-scale' => 'Justicia',
            'fas fa-leaf' => 'Medio Ambiente',
            'fas fa-road' => 'Infraestructura',
            'fas fa-eye' => 'Transparencia',
            'fas fa-bullhorn' => 'General'
        ];

        return view('admin.propuestas.edit', compact('candidato', 'propuesta', 'categorias', 'iconos'));
    }

    public function update(Request $request, Candidato $candidato, Propuesta $propuesta)
    {
        if ($propuesta->candidato_id !== $candidato->id) {
            abort(404);
        }

        $request->validate([
            'titulo' => 'required|string|max:200',
            'descripcion' => 'required|string',
            'categoria' => 'required|in:seguridad,educacion,economia,salud,social,justicia,medio_ambiente,infraestructura,transparencia,otros',
            'icono' => 'required|string|max:50',
            'color' => 'required|string|size:7',
            'orden' => 'nullable|integer',
            'destacada' => 'boolean',
            'metas' => 'nullable|array',
            'indicadores' => 'nullable|array'
        ]);

        $propuesta->update($request->all());

        return redirect()->route('admin.candidatos.propuestas.index', $candidato)
            ->with('success', 'Propuesta actualizada exitosamente.');
    }

    public function destroy(Candidato $candidato, Propuesta $propuesta)
    {
        if ($propuesta->candidato_id !== $candidato->id) {
            abort(404);
        }

        $propuesta->delete();

        return redirect()->route('admin.candidatos.propuestas.index', $candidato)
            ->with('success', 'Propuesta eliminada exitosamente.');
    }

    public function toggleDestacada(Candidato $candidato, Propuesta $propuesta)
    {
        if ($propuesta->candidato_id !== $candidato->id) {
            abort(404);
        }

        $propuesta->update(['destacada' => !$propuesta->destacada]);

        return redirect()->back()
            ->with('success', 'Estado de propuesta destacada actualizado.');
    }

    public function reordenar(Request $request, Candidato $candidato)
    {
        $request->validate([
            'propuestas' => 'required|array',
            'propuestas.*.id' => 'required|exists:propuestas,id,candidato_id,' . $candidato->id,
            'propuestas.*.orden' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->propuestas as $item) {
                Propuesta::where('id', $item['id'])->update(['orden' => $item['orden']]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orden actualizado']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}