<?php

namespace FLAIRUK\Aircrafts\Tests;

use FLAIRUK\Aircrafts\AircraftsServiceProvider;
use FLAIRUK\Aircrafts\Facades\Aircrafts;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [AircraftsServiceProvider::class];
    }

    protected function getPackageAliases($app): array
    {
        return ['Aircrafts' => Aircrafts::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
    }
}
