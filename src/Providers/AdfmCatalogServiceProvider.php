<?php

namespace Wtolk\AdfmCatalog\Providers;

use Illuminate\Support\ServiceProvider;

class AdfmCatalogServiceProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__.'/../Controllers' => app_path('Http/Controllers'),
            __DIR__.'/../Models' => app_path('Models/Adfm/Catalog'),
            __DIR__.'/../views' => resource_path('views/adfm/public/catalog'),
            __DIR__.'/../routes' => base_path('/routes/adfm'),
            __DIR__.'/../database/migrations' => app_path('../database/migrations'),
        ]);
    }
}
