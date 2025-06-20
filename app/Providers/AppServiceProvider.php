<?php

namespace App\Providers;
use App\Models\Actividad;
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
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $notificacionesRecientes = Actividad::where('actor_id', auth()->id())
                ->orWhere('afectado_id', auth()->id())
                ->latest()
                ->take(5)
                ->get();

            $hayNoLeidas = $notificacionesRecientes->where('leida', false)->count() > 0;

            $view->with([
                'notificacionesRecientes' => $notificacionesRecientes,
                'hayNotificacionesNoLeidas' => $hayNoLeidas
            ]);
        });
    }
}
