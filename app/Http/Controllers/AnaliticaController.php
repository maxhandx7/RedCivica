<?php

namespace App\Http\Controllers;

use App\Models\Campaña;
use App\Models\Referencia;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnaliticaController extends Controller
{
    // ═══════════════════════════════════════════════════════════════
    //  INDEX — Panel principal
    // ═══════════════════════════════════════════════════════════════
    public function index()
    {
        return view('admin.analitica.index', [
            'kpis'                  => $this->kpisGlobales(),
            'referenciasPorCampaña' => $this->referenciasPorCampaña(),
            'topReferencias'        => $this->topReferencias(),
            'rankingReferidores'    => $this->rankingReferidores(),
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  DETALLE — Usuarios que llegaron por una referencia concreta
    // ═══════════════════════════════════════════════════════════════
    public function usuariosPorReferencia(int $referenciaId)
    {
        $referencia = Referencia::with('user', 'campaña')->findOrFail($referenciaId);

        $usuarios = $referencia->usuariosRegistrados()
            ->latest()
            ->paginate(25);

        return view('admin.analitica.usuarios_por_referencia', compact('referencia', 'usuarios'));
    }

    // ═══════════════════════════════════════════════════════════════
    //  PRIVADOS — Cada uno resuelve UNA sola pregunta
    // ═══════════════════════════════════════════════════════════════

    /**
     * KPIs globales del sistema.
     *
     * Responde:
     *  - ¿Cuántos links de marketing existen?
     *  - ¿Cuántos usuarios llegaron a través de un link?
     *  - ¿Cuántos links han traído al menos un usuario?
     *  - ¿Cuál es el promedio de usuarios por link activo?
     *  - ¿Cuántos usuarios tienen al menos un referido en su red política?
     */
    private function kpisGlobales(): array
    {
        $totalReferencias         = Referencia::count();
        $usuariosDesdeReferencias = User::whereNotNull('referencia_id')->count();
        $referenciasActivas       = Referencia::has('usuariosRegistrados')->count();

        return [
            'total_referencias'          => $totalReferencias,
            'usuarios_desde_referencias' => $usuariosDesdeReferencias,
            'referencias_activas'        => $referenciasActivas,
            'promedio_por_referencia'    => $referenciasActivas > 0
                                                ? round($usuariosDesdeReferencias / $referenciasActivas, 2)
                                                : 0,
            // usuarios_con_referidos usa parent_id (red política), NO referencia_id
            'usuarios_con_referidos'     => User::has('children')->count(),
        ];
    }

    /**
     * Agrupa por campaña: cuántos links y cuántos usuarios llegaron por cada una.
     *
     * Responde: ¿qué campaña de marketing funciona mejor?
     *
     * Una sola query con subqueries correlacionadas; sin N+1.
     */
    private function referenciasPorCampaña()
    {
        return Campaña::select('campañas.id', 'campañas.name')
            ->selectSub(
                DB::table('referencias')
                    ->selectRaw('COUNT(*)')
                    ->whereColumn('referencias.campaña_id', 'campañas.id'),
                'total_referencias'
            )
            ->selectSub(
                DB::table('users')
                    ->selectRaw('COUNT(*)')
                    ->whereIn(
                        'users.referencia_id',
                        DB::table('referencias')
                            ->select('id')
                            ->whereColumn('referencias.campaña_id', 'campañas.id')
                    ),
                'total_usuarios'
            )
            ->having('total_referencias', '>', 0)
            ->orderByDesc('total_usuarios')
            ->get();
    }

    /**
     * Top N links de marketing ordenados por usuarios convertidos.
     *
     * Responde: ¿qué links específicos trajeron más gente?
     */
    private function topReferencias(int $limit = 10)
    {
        return Referencia::with('user:id,name,surname', 'campaña:id,name')
            ->withCount('usuariosRegistrados')
            ->having('usuarios_registrados_count', '>', 0)
            ->orderByDesc('usuarios_registrados_count')
            ->limit($limit)
            ->get();
    }

    /**
     * Ranking de usuarios que más personas han traído a la red (árbol parent_id).
     *
     * Responde: ¿quién está creciendo más su red política?
     *
     * IMPORTANTE: esto es distinto a referencias de marketing.
     * parent_id = quién me trajo a la red política.
     * referencia_id = por qué link de campaña me registré.
     */
    private function rankingReferidores(int $limit = 10)
    {
        return User::select('id', 'name', 'surname', 'cedula')
            ->withCount('children')
            ->having('children_count', '>', 0)
            ->orderByDesc('children_count')
            ->limit($limit)
            ->get();
    }
}