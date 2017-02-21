<?php

namespace ijeffro\Aircrafts;

use Illuminate\Support\ServiceProvider;

/**
 * CountryListServiceProvider
 *
 */

class AircraftsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
    * Bootstrap the application.
    *
    * @return void
    */
    public function boot()
    {
        // The publication files to publish
        $this->publishes([__DIR__ . '/../../config/config.php' => config_path('aircrafts.php')]);

        // Append the country settings
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php', 'aircrafts'
        );
        /*$this->app['config']['database.connections'] = array_merge(
            $this->app['config']['database.connections'],
            \Config::get('career.library.database.connections')
        );*/
    }

    /**
     * Register everything.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAircrafts();
        $this->registerCommands();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registerAircrafts()
    {
        $this->app->bind('aircrafts', function($app)
        {
            return new Aircrafts();
        });
    }

    /**
     * Register the artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->app->singleton('command.aircrafts.migration', function ($app)
        {
            return new MigrationCommand($app);
        });

        $this->commands('command.aircrafts.migration');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('aircrafts');
    }
}
