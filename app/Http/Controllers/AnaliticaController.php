<?php

namespace App\Http\Controllers;

use App\Models\Referencia;
use App\Models\User;
use Illuminate\Http\Request;

class AnaliticaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    public function index()
    {
        $user = auth()->user();

        // 📊 Total de referencias por campaña
        $referenciasPorCampaña = \DB::table('referencias')
            ->join('campañas', 'referencias.campaña_id', '=', 'campañas.id')
            ->select('campañas.name', \DB::raw('COUNT(*) as total'))
            ->groupBy('campañas.name')
            ->pluck('total', 'campañas.name');

        // 👥 Usuarios registrados por referencia (dentro de tu red)
        $descendientes = $user->descendants()->whereNotNull('referencia_id')->get();
        $usuariosPorReferencia = $descendientes
            ->groupBy('referencia_id')
            ->map(fn($grupo) => $grupo->count());

        // 🧩 Otros KPIs
        $usuariosConReferidos = User::has('referencias')->count();


        $totalReferencias = Referencia::count();
        $usuariosDesdeReferencias = User::whereNotNull('referencia_id')->count();

        $referenciasConUsuarios = Referencia::has('usuariosRegistrados')->count();

        $conversion = $referenciasConUsuarios > 0
            ? round($usuariosDesdeReferencias / $referenciasConUsuarios, 2)
            : 0;

        /*  $conversion = $totalReferencias > 0
             ? round(($referenciasConUsuarios / $totalReferencias) * 100, 2)
             : 0; */






        $usuariosPorReferencia = $descendientes
            ->load('referencia.user')
            ->groupBy('referencia_id')
            ->mapWithKeys(function ($grupo, $refId) {

                $referencia = $grupo->first()->referencia;
                $nombre = optional($referencia->user)->name ?? 'Sin nombre';
                $campaña = optional($referencia->campaña)->name ?? 'Sin campaña';
                return ["$nombre – $campaña ($refId)" => $grupo->count()];
            });
        return view('admin.analitica.index', compact(
            'referenciasPorCampaña',
            'usuariosPorReferencia',
            'usuariosConReferidos',
            'conversion',
            'usuariosDesdeReferencias',
            'totalReferencias'
        ));

    }


    public function usuariosPorReferencia($id)
    {
        $referencia = Referencia::with('user')->findOrFail($id);

        $usuarios = $referencia->usuariosRegistrados;

        return view(
            'admin.analitica.usuarios_por_referencia',
            compact('usuarios', 'referencia')
        );
    }

}