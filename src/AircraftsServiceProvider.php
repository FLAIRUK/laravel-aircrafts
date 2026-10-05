<?php

namespace FLAIRUK\Aircrafts;

use Illuminate\Support\ServiceProvider;

class AircraftsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/aircrafts.php', 'aircrafts');

        $this->app->singleton(Aircrafts::class);
        $this->app->alias(Aircrafts::class, 'aircrafts');
    }

    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/aircrafts.php' => config_path('aircrafts.php'),
        ], 'aircrafts-config');

        $this->publishesMigrations([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'aircrafts-migrations');

        $this->commands([
            Console\InstallCommand::class,
            Console\SeedCommand::class,
        ]);
    }
}
