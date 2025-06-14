<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class Greeting extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $now = Carbon::now('America/Bogota');
        $saludo = '';

        if ($now->hour >= 5 && $now->hour < 12) {
            $saludo = 'Buenos días,';
        } elseif ($now->hour >= 12 && $now->hour < 19) {
            $saludo = 'Buenas tardes,';
        } else {
            $saludo = 'Buenas noches,';
        }
       
        view()->share('saludo', $saludo);
    }
}
