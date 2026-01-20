<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\Propuesta;
use App\Models\Tarjeton;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CandidatoController extends Controller
{
    public function index()
    {
        $candidatos = Candidato::withCount('propuestas')
            ->orderBy('orden')
            ->paginate(5);

        return view('admin.candidatos.index', compact('candidatos'));
    }

    public function create()
    {
        $cargos = [
            'senador' => 'Senador',
            'representante' => 'Representante',
            'presidente' => 'Presidente',
            'gobernador' => 'Gobernador',
            'alcalde' => 'Alcalde'
        ];

        return view('admin.candidatos.create', compact('cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'alias' => 'nullable|string|max:50',
            'cargo' => 'required|in:senador,representante,presidente,gobernador,alcalde',
            'circunscripcion' => 'required|string|max:200',
            'partido' => 'required|string|max:100',
            'lema' => 'nullable|string|max:255',
            'color_principal' => 'nullable|string|size:7',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biografia' => 'nullable|string',
            'fecha_eleccion' => 'required|date',
            'activo' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('imagen');
            
            if ($request->hasFile('imagen')) {
                $imagenPath = $request->file('imagen')->store('candidatos', 'public');
                $data['imagen'] = $imagenPath;
            }

            $candidato = Candidato::create($data);

            DB::commit();

            return redirect()->route('admin.candidatos.show', $candidato)
                ->with('success', 'Candidato creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el candidato: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Candidato $candidato)
    {
        $candidato->load([
            'propuestas' => function($q) {
                $q->orderBy('orden');
            },
            'tarjetones',
            'metricas' => function($q) {
                $q->orderBy('fecha_medicion', 'desc');
            },
            'documentos' => function($q) {
                $q->orderBy('tipo');
            }
        ]);

        // Estadísticas
        $estadisticas = [
            'total_propuestas' => $candidato->propuestas->count(),
            'propuestas_por_categoria' => $candidato->propuestas->groupBy('categoria')->map->count(),
            'total_tarjetones' => $candidato->tarjetones->count(),
            'total_documentos' => $candidato->documentos->count(),
            'metricas_recientes' => $candidato->metricas->take(5)
        ];

        return view('admin.candidatos.show', compact('candidato', 'estadisticas'));
    }

    public function edit(Candidato $candidato)
    {
        $cargos = [
            'senador' => 'Senador',
            'representante' => 'Representante',
            'presidente' => 'Presidente',
            'gobernador' => 'Gobernador',
            'alcalde' => 'Alcalde'
        ];

        return view('admin.candidatos.edit', compact('candidato', 'cargos'));
    }

    public function update(Request $request, Candidato $candidato)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'alias' => 'nullable|string|max:50',
            'cargo' => 'required|in:senador,representante,presidente,gobernador,alcalde',
            'circunscripcion' => 'required|string|max:200',
            'partido' => 'required|string|max:100',
            'lema' => 'nullable|string|max:255',
            'color_principal' => 'nullable|string|size:7',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'biografia' => 'nullable|string',
            'fecha_eleccion' => 'required|date',
            'activo' => 'boolean',
            'orden' => 'nullable|integer'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->except('imagen');
            
            if ($request->hasFile('imagen')) {
                // Eliminar imagen anterior si existe
                if ($candidato->imagen) {
                    Storage::disk('public')->delete($candidato->imagen);
                }
                
                $imagenPath = $request->file('imagen')->store('candidatos', 'public');
                $data['imagen'] = $imagenPath;
            }

            $candidato->update($data);

            DB::commit();

            return redirect()->route('admin.candidatos.show', $candidato)
                ->with('success', 'Candidato actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el candidato: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Candidato $candidato)
    {
        try {
            DB::beginTransaction();

            // Eliminar imagen si existe
            if ($candidato->imagen) {
                Storage::disk('public')->delete($candidato->imagen);
            }

            $candidato->delete();

            DB::commit();

            return redirect()->route('admin.candidatos.index')
                ->with('success', 'Candidato eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al eliminar el candidato: ' . $e->getMessage());
        }
    }

    public function toggleActivo(Candidato $candidato)
    {
        $candidato->update(['activo' => !$candidato->activo]);
        
        return redirect()->back()
            ->with('success', 'Estado del candidato actualizado.');
    }

    public function reordenar(Request $request)
    {
        $request->validate([
            'candidatos' => 'required|array',
            'candidatos.*.id' => 'required|exists:candidatos,id',
            'candidatos.*.orden' => 'required|integer'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->candidatos as $item) {
                Candidato::where('id', $item['id'])->update(['orden' => $item['orden']]);
            }

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Orden actualizado']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function metricas(Candidato $candidato)
    {
        $metricas = $candidato->metricas()
            ->orderBy('fecha_medicion', 'desc')
            ->get();

        $tiposMetricas = $metricas->pluck('tipo_metrica')->unique();

        return view('admin.candidatos.metricas', compact('candidato', 'metricas', 'tiposMetricas'));
    }

    public function guardarMetrica(Request $request, Candidato $candidato)
    {
        $request->validate([
            'tipo_metrica' => 'required|string|max:50',
            'nombre' => 'required|string|max:100',
            'valor' => 'required|numeric',
            'unidad' => 'nullable|string|max:20',
            'fecha_medicion' => 'required|date',
            'metadata' => 'nullable|array'
        ]);

        $candidato->metricas()->create($request->all());

        return redirect()->back()
            ->with('success', 'Métrica guardada exitosamente.');
    }
}