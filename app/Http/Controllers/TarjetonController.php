<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Candidato;
use App\Models\Tarjeton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TarjetonController extends Controller
{
    public function index()
    {
        $tarjetones = Tarjeton::with('candidato')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.tarjetones.index', compact('tarjetones'));
    }

    public function create()
    {
        $candidatos = Candidato::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.tarjetones.create', compact('candidatos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidato_id' => 'required|exists:candidatos,id',
            'nombre' => 'required|string|max:200',
            'total_opciones' => 'required|integer|min:1|max:1000',
            'instruccion' => 'nullable|string|max:500',
            'secciones' => 'required|array|min:1',
            'secciones.*.nombre' => 'required|string|max:100',
            'secciones.*.inicio' => 'required|integer|min:1',
            'secciones.*.fin' => 'required|integer|min:1|gte:secciones.*.inicio',
            'configuracion.color_primario' => 'nullable|string|size:7',
            'configuracion.color_secundario' => 'nullable|string|size:7',
            'configuracion.mostrar_numeros' => 'nullable|boolean',
            'configuracion.mostrar_nombres' => 'nullable|boolean',
            'activo' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Preparar secciones
            $secciones = [];
            foreach ($request->secciones as $seccion) {
                $secciones[] = [
                    'nombre' => $seccion['nombre'],
                    'rango' => [$seccion['inicio'], $seccion['fin']],
                    'total_opciones' => $seccion['fin'] - $seccion['inicio'] + 1
                ];
            }

            // Verificar que la suma de opciones coincida con total_opciones
            $totalCalculado = array_sum(array_column($secciones, 'total_opciones'));
            if ($totalCalculado != $request->total_opciones) {
                return redirect()->back()
                    ->with('error', 'La suma de opciones en las secciones no coincide con el total especificado.')
                    ->withInput();
            }

            $tarjeton = Tarjeton::create([
                'candidato_id' => $request->candidato_id,
                'nombre' => $request->nombre,
                'total_opciones' => $request->total_opciones,
                'instruccion' => $request->instruccion,
                'secciones' => $secciones,
                'configuracion' => $request->configuracion ?? [],
                'activo' => $request->activo ?? true
            ]);

            DB::commit();

            return redirect()->route('admin.tarjetones.show', $tarjeton)
                ->with('success', 'Tarjetón creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al crear el tarjetón: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Tarjeton $tarjeton)
    {
        $tarjeton->load('candidato');
        
        // Preparar datos para la vista previa
        $seccionesConOpciones = [];
        $numeroActual = 1;
        
        foreach ($tarjeton->secciones as $seccion) {
            $opciones = [];
            for ($i = $seccion['rango'][0]; $i <= $seccion['rango'][1]; $i++) {
                $opciones[] = $i;
            }
            
            $seccionesConOpciones[] = [
                'nombre' => $seccion['nombre'],
                'rango' => $seccion['rango'],
                'opciones' => $opciones
            ];
        }
        
        return view('admin.tarjetones.show', compact('tarjeton', 'seccionesConOpciones'));
    }

    public function edit(Tarjeton $tarjetone)
    {
        $candidatos = Candidato::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('admin.tarjetones.edit', compact('tarjetone', 'candidatos'));
    }

    public function update(Request $request, Tarjeton $tarjeton)
    {
        $request->validate([
            'candidato_id' => 'required|exists:candidatos,id',
            'nombre' => 'required|string|max:200',
            'total_opciones' => 'required|integer|min:1|max:1000',
            'instruccion' => 'nullable|string|max:500',
            'secciones' => 'required|array|min:1',
            'secciones.*.nombre' => 'required|string|max:100',
            'secciones.*.inicio' => 'required|integer|min:1',
            'secciones.*.fin' => 'required|integer|min:1|gte:secciones.*.inicio',
            'configuracion.color_primario' => 'nullable|string|size:7',
            'configuracion.color_secundario' => 'nullable|string|size:7',
            'configuracion.mostrar_numeros' => 'nullable|boolean',
            'configuracion.mostrar_nombres' => 'nullable|boolean',
            'activo' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            // Preparar secciones
            $secciones = [];
            foreach ($request->secciones as $seccion) {
                $secciones[] = [
                    'nombre' => $seccion['nombre'],
                    'rango' => [$seccion['inicio'], $seccion['fin']],
                    'total_opciones' => $seccion['fin'] - $seccion['inicio'] + 1
                ];
            }

            // Verificar que la suma de opciones coincida con total_opciones
            $totalCalculado = array_sum(array_column($secciones, 'total_opciones'));
            if ($totalCalculado != $request->total_opciones) {
                return redirect()->back()
                    ->with('error', 'La suma de opciones en las secciones no coincide con el total especificado.')
                    ->withInput();
            }

            $tarjeton->update([
                'candidato_id' => $request->candidato_id,
                'nombre' => $request->nombre,
                'total_opciones' => $request->total_opciones,
                'instruccion' => $request->instruccion,
                'secciones' => $secciones,
                'configuracion' => $request->configuracion ?? [],
                'activo' => $request->activo ?? $tarjeton->activo
            ]);

            DB::commit();

            return redirect()->route('admin.tarjetones.show', $tarjeton)
                ->with('success', 'Tarjetón actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar el tarjetón: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Tarjeton $tarjeton)
    {
        try {
            $tarjeton->delete();
            
            return redirect()->route('admin.tarjetones.index')
                ->with('success', 'Tarjetón eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el tarjetón: ' . $e->getMessage());
        }
    }

    public function toggleActivo(Tarjeton $tarjeton)
    {
        $tarjeton->update(['activo' => !$tarjeton->activo]);
        
        return redirect()->back()
            ->with('success', 'Estado del tarjetón actualizado.');
    }

    public function preview(Tarjeton $tarjeton)
    {
        $tarjeton->load('candidato');
        
        // Generar vista previa completa
        $opcionesCompletas = [];
        foreach ($tarjeton->secciones as $seccion) {
            for ($i = $seccion['rango'][0]; $i <= $seccion['rango'][1]; $i++) {
                $opcionesCompletas[] = [
                    'numero' => $i,
                    'seccion' => $seccion['nombre'],
                    'marcado' => false
                ];
            }
        }
        
        return view('admin.tarjetones.preview', compact('tarjeton', 'opcionesCompletas'));
    }

    public function exportPdf(Tarjeton $tarjeton)
    {
        $tarjeton->load('candidato');
        
        // Lógica para exportar a PDF
        return response()->streamDownload(function() use ($tarjeton) {
            // Aquí iría la generación del PDF
            echo "PDF del tarjetón: " . $tarjeton->nombre;
        }, 'tarjeton-' . $tarjeton->id . '.pdf');
    }

    public function exportImage(Tarjeton $tarjeton)
    {
        $tarjeton->load('candidato');
        
        // Lógica para exportar a imagen
        return response()->streamDownload(function() use ($tarjeton) {
            // Aquí iría la generación de la imagen
            echo "Imagen del tarjetón: " . $tarjeton->nombre;
        }, 'tarjeton-' . $tarjeton->id . '.png');
    }

    public function duplicate(Tarjeton $tarjeton)
    {
        try {
            DB::beginTransaction();

            $nuevoTarjeton = $tarjeton->replicate();
            $nuevoTarjeton->nombre = $tarjeton->nombre . ' (Copia)';
            $nuevoTarjeton->save();

            DB::commit();

            return redirect()->route('admin.tarjetones.edit', $nuevoTarjeton)
                ->with('success', 'Tarjetón duplicado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al duplicar el tarjetón: ' . $e->getMessage());
        }
    }
}