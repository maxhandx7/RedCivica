<?php

namespace App\Http\Controllers;

use App\Models\Candidato;
use App\Models\Documento;
use App\Models\Propuesta;
use App\Models\Tarjeton;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('candidatoPage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }



    public function candidatoDash()
    
    {
        $totalCandidatos = Candidato::count();
        $candidatosActivos = Candidato::where('activo', true)->count();
        
        $totalPropuestas = Propuesta::count();
        $propuestasDestacadas = Propuesta::where('destacada', true)->count();
        
        $totalTarjetones = Tarjeton::count();
        $tarjetonesActivos = Tarjeton::where('activo', true)->count();
        
        $totalDocumentos = Documento::count();
        $documentosPublicos = Documento::where('publico', true)->count();
        
        $candidatosRecientes = Candidato::withCount('propuestas')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Propuestas por categoría
        $propuestasPorCategoria = Propuesta::selectRaw('categoria, count(*) as total')
            ->groupBy('categoria')
            ->pluck('total', 'categoria')
            ->toArray();
        
        // Formatear nombres de categorías
        $categoriasFormateadas = [];
        foreach ($propuestasPorCategoria as $categoria => $total) {
            $categoriasFormateadas[ucfirst(str_replace('_', ' ', $categoria))] = $total;
        }
        
        return view('candidato', compact(
            'totalCandidatos',
            'candidatosActivos',
            'totalPropuestas',
            'propuestasDestacadas',
            'totalTarjetones',
            'tarjetonesActivos',
            'totalDocumentos',
            'documentosPublicos',
            'candidatosRecientes',
            'propuestasPorCategoria', 'categoriasFormateadas'
        ));
    
    }

    public function candidatoPage($alias)
    {
        $candidato = Candidato::where('alias', $alias)->firstOrFail();
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

        return view('landing', compact('candidato', 'estadisticas'));
    }
}
