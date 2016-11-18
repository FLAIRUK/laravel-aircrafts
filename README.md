# Laravel Aircrafts

[![Latest Stable Version](https://poser.pugx.org/ijeffro/laravel-aircrafts/v/stable)](https://packagist.org/packages/ijeffro/laravel-aircrafts)
[![Total Downloads](https://poser.pugx.org/ijeffro/laravel-aircrafts/downloads)](https://packagist.org/packages/ijeffro/laravel-aircrafts)
[![Latest Unstable Version](https://poser.pugx.org/ijeffro/laravel-aircrafts/v/unstable)](https://packagist.org/packages/ijeffro/laravel-aircrafts)
[![License](https://poser.pugx.org/ijeffro/laravel-aircrafts/license)](https://packagist.org/packages/ijeffro/laravel-aircrafts)

Laravel Aircrafts is a bundle for Laravel, providing Iata Code ISO 3166_3 and country codes for all the aircrafts.

**Please note that the dev-master version is for Laravel 5 only**

## Installation

Run `composer require ijeffro/laravel-aircrafts dev-master` in your Laravel root directory to install the latest version.

Or add `ijeffro/laravel-aircrafts` to `composer.json`.

    "ijeffro/laravel-aircrafts": "dev-master"

Run `composer update` to pull down the latest version of Aircraft List.

Edit `app/config/app.php` and add the `provider` and `filter`

    'providers' => [
        ijeffro\Aircrafts\AircraftsServiceProvider::class,
    ]

Now add the alias.

    'aliases' => [
        'Aircrafts' => ijeffro\Aircrafts\AircraftsFacade::class,
    ]


## Model

You can start by publishing the configuration. This is an optional step, it contains the table name and does not need to be altered. If the default name `aircrafts` suits you, leave it. Otherwise run the following command

    $ php artisan vendor:publish

Next generate the migration file:

    $ php artisan aircrafts:migration

It will generate the `<timestamp>_setup_aircrafts_table.php` migration and the `AircraftsSeeder.php` seeder. To make sure the data is seeded insert the following code in the `seeds/DatabaseSeeder.php`

    //Seed the aircrafts
    $this->call('AircraftsSeeder');
    $this->command->info('Seeded the aircrafts!');

You may now run it with the artisan migrate command:

    $ php artisan migrate --seed

After running this command the filled aircrafts table will be available
