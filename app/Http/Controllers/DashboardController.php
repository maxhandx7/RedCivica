<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $referidosTotales = $user->descendants()->count();
        $total = $user->descendants()->count();
        $conReferidos = $user->descendants()->has('children')->count();
        $recientes = $user->descendants()
            ->where('created_at', '>=', now()->subDays(15))
            ->count();

        $probabilidadVoto = $total > 0
            ? round((($conReferidos + $recientes) / (2 * $total)) * 100)
            : 0;
        $partidariosActivos = User::has('parent')->count();

        return view('home', compact(
            'referidosTotales',
            'probabilidadVoto',
            'partidariosActivos'
        ));
    }
}
