<?php

namespace App\Providers;

use App\Models\Business as ModelsBusiness;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class Business extends ServiceProvider
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
        if (Schema::hasTable('businesses')) {
            $business = ModelsBusiness::get();
            if ($business->isNotEmpty()) {
                $business = ModelsBusiness::where('id', 1)->firstOrFail();
                view()->share('business', $business);
            }
        } else {
            view()->share('business', null);
        }
    }
}
