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
            __DIR__.'/../email' => resource_path('views/adfm/email'),
            __DIR__.'/../Livewire/Classes' => app_path('Http/Livewire'),
            __DIR__.'/../Livewire/views' => resource_path('views/livewire'),
            __DIR__.'/../routes' => base_path('/routes/adfm'),
            __DIR__.'/../database/migrations' => app_path('../database/migrations'),
            __DIR__.'/../database/factories' => app_path('../database/factories/Adfm/Catalog'),
            __DIR__.'/../database/seeders' => app_path('../database/seeders'),
        ]);

        if (file_exists(base_path('/routes/adfm') . '/catalog-routes.php')) {
            $this->loadRoutesFrom(base_path('/routes/adfm') . '/catalog-routes.php');
        } else {
            $this->loadRoutesFrom(__DIR__.'/../routes' . '/catalog-routes.php');
        }
    }
}
