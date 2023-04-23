<?php

namespace App\Providers;

use App\Services\ChileCrece;
use App\Services\ProgActivos;
use App\Services\RegCivil;
use App\Services\Sigec;
use Illuminate\Support\ServiceProvider;

class ExternalWebServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(RegCivil::class, function ($app) {
            return new RegCivil();
        });
        $this->app->bind(ProgActivos::class, function ($app) {
            return new ProgActivos();
        });
        $this->app->bind(ChileCrece::class, function ($app) {
            return new ChileCrece();
        });
        $this->app->bind(Sigec::class, function ($app) {
            return new Sigec();
        });
    }
}
