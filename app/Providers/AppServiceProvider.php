<?php

namespace App\Providers;
use App\Models\Actividad;
use App\Models\Candidato;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    /* public function boot(): void
    {
        view()->composer('*', function ($view) {
            $notificacionesRecientes = Actividad::where('actor_id', auth()->id())
                ->orWhere('afectado_id', auth()->id())
                ->latest()
                ->take(5)
                ->get();

            $hayNoLeidas = $notificacionesRecientes->where('leida', false)->count() > 0;
            $candidatos = Candidato::all();
            $view->with([
                'notificacionesRecientes' => $notificacionesRecientes,
                'hayNotificacionesNoLeidas' => $hayNoLeidas,
                'candidato' => $candidatos,
            ]);
        });
        Paginator::useBootstrap();
    }  */

    public function boot(): void
    {
        view()->composer('layouts.*', function ($view) {
            if (!auth()->check())
                return;

            $notificacionesRecientes = Actividad::where(function ($q) {
                $q->where('actor_id', auth()->id())
                    ->orWhere('afectado_id', auth()->id());
            })
                ->latest()
                ->take(5)
                ->get();

            $view->with([
                'notificacionesRecientes' => $notificacionesRecientes,
                'hayNotificacionesNoLeidas' => $notificacionesRecientes->where('leida', false)->isNotEmpty(),
                'candidatos' => Candidato::select('id', 'alias')->get(),
            ]);
        });
        Paginator::useBootstrap();
    }
}
