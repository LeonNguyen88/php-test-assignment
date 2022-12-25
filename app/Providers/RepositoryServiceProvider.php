<?php

namespace App\Providers;

use App\AirtableDrawing;
use App\AirtableModel;
use App\AirtableModelModel;
use App\AirtableService;
use App\Contracts\AirtableDrawingRepositoryContract;
use App\Contracts\AirtableModelModelRepositoryContract;
use App\Contracts\AirtableModelRepositoryContract;
use App\Contracts\AirtableServiceRepositoryContract;
use App\Repositories\AirtableDrawingRepository;
use App\Repositories\AirtableModelModelRepository;
use App\Repositories\AirtableModelRepository;
use App\Repositories\AirtableServiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;
    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AirtableModelRepositoryContract::class, function () {
            return new AirtableModelRepository(new AirtableModel());
        });
        $this->app->singleton(AirtableModelModelRepositoryContract::class, function () {
            return new AirtableModelModelRepository(new AirtableModelModel());
        });
        $this->app->singleton(AirtableServiceRepositoryContract::class, function () {
            return new AirtableServiceRepository(new AirtableService());
        });
        $this->app->singleton(AirtableDrawingRepositoryContract::class, function () {
            return new AirtableDrawingRepository(new AirtableDrawing());
        });
    }


    /**
     * Get the services provided by the provider.
     * @return array
     */
    public function provides()
    {
        return [
            AirtableModelRepositoryContract::class,

            AirtableModelModelRepositoryContract::class,
            AirtableDrawingRepositoryContract::class,
            AirtableServiceRepositoryContract::class,
        ];
    }
}
