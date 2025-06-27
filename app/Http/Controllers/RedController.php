<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class RedController extends Controller
{

    /*         public function index(Request $request)
    {
        // Opción 1: Para árboles pequeños (< 1,000 nodos)
        $referidos = auth()->user()
            ->descendantsAndSelf()
            ->depthFirst() // Usa el withDepth() de laravel-nestedset
            ->select(['id', 'name', 'cedula', 'parent_id', 'barrio', 'ciudad', 'mesa', 'created_at'])
            ->orderBy('depth')
            ->orderBy('created_at', 'desc')
            ->paginate(100); // Paginación

        // Opción 2: Para árboles grandes (consultas optimizadas)
        if ($request->has('search')) {
            $referidos = auth()->user()
                ->descendantsAndSelf()
                ->where(function($query) use ($request) {
                    $query->where('name', 'like', '%'.$request->search.'%')
                          ->orWhere('cedula', 'like', '%'.$request->search.'%');
                })
                ->depthFirst()
                ->paginate(100);
        }

        // Formatear fechas
        $referidos->each(function ($referido) {
            $referido->formatted_date = $referido->created_at->isoFormat('D [de] MMMM [de] YYYY');
            $referido->nivel = $referido->getDepthName; // Usamos depth directamente
        });

        return view('admin.red.index', [
            'referidos' => $referidos,
            'networkData' => $this->prepareNetworkData($referidos),
        ]);
    }

    protected function prepareNetworkData($referidos)
    {
        return $referidos->map(function ($u) {
            return [
                'id' => (string) $u->id,
                'name' => $u->name,
                'cedula' => $u->cedula,
                'parent_id' => $u->parent_id ? (string) $u->parent_id : null,
                'nivel' => $u->depth,
            ];
        });
    } */
    public function index()
    {
        $referidos = auth()->user()->descendantsAndSelf()->depthFirst()->get();

        $networkData = $referidos->map(function ($u) use ($referidos) {
            $nivel = 1;
            $parent = $u;

            // dd($parent->parent_id && $parent->parent_id !== auth()->id());

            while ($parent && $parent->parent_id && $parent->parent_id !== auth()->id()) {
                $nivel++;
                $parent = $referidos->firstWhere('id', $parent->parent_id);

                // Si no encontramos al padre, salimos del bucle
                if (!$parent) {
                    break;
                }
            }

            return [
                'id' => (string) $u->id, // 👈 FORZAR STRING
                'name' => $u->name,
                'cedula' => $u->cedula,
                'parent_id' => (string) $u->parent_id,
                'nivel' => $nivel,
                'no' => $u->children->count(), // 👈 Número de hijos directos
            ];
        });

        // Formato para vista humana
        foreach ($referidos as $referido) {
            $referido->formatted_date = $referido->created_at->isoFormat('D [de] MMMM [de] YYYY');
        }

        // 🔥 NUEVO: Top 3 usuarios con más hijos directos (excluyéndote a ti mismo)
        $topReferidores = \App\Models\User::withCount('children')
            ->whereIn('id', $referidos->pluck('id')->toArray()) // Solo los de la red
            ->where('id', '!=', auth()->id())
            ->orderByDesc('children_count')
            ->take(3)
            ->get();

        return view('admin.red.index', [
            'referidos' => $referidos,
            'networkData' => $networkData,
            'topReferidores' => $topReferidores, // 👈 lo pasamos a la vista
        ]);
    }

}
