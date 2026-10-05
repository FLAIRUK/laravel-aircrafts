<?php

namespace FLAIRUK\Aircrafts\Tests;

use FLAIRUK\Aircrafts\Database\AircraftsSeeder;
use FLAIRUK\Aircrafts\Facades\Aircrafts;
use FLAIRUK\Aircrafts\Models\Aircraft;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

class DatabaseTest extends TestCase
{
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    #[Test]
    public function the_seed_command_fills_the_table_and_is_idempotent(): void
    {
        $this->artisan('aircrafts:seed')->assertSuccessful();
        $this->artisan('aircrafts:seed')->assertSuccessful();

        $this->assertSame(Aircrafts::all()->count(), Aircraft::count());
        $this->assertSame('Boeing 737-800', Aircraft::code('738')->first()->name);
    }

    #[Test]
    public function the_seeder_can_be_called_from_an_application_seeder(): void
    {
        $this->seed(AircraftsSeeder::class);

        $this->assertSame(Aircrafts::all()->count(), Aircraft::count());
    }

    #[Test]
    public function prune_removes_rows_that_are_not_in_the_dataset(): void
    {
        Aircraft::create(['id' => 999999, 'code' => 'ZZ9', 'name' => 'Retired Type']);

        $this->artisan('aircrafts:seed', ['--prune' => true])->assertSuccessful();

        $this->assertNull(Aircraft::find(999999));
        $this->assertSame(Aircrafts::all()->count(), Aircraft::count());
    }

    #[Test]
    public function the_table_name_is_configurable(): void
    {
        config(['aircrafts.table' => 'iata_aircrafts']);
        (require __DIR__.'/../database/migrations/create_aircrafts_table.php')->up();

        $this->artisan('aircrafts:seed')->assertSuccessful();

        $this->assertTrue(Schema::hasTable('iata_aircrafts'));
        $this->assertSame(Aircrafts::all()->count(), Aircraft::count());
    }

    #[Test]
    public function install_publishes_the_config_and_a_timestamped_migration(): void
    {
        $migrations = database_path('migrations');
        File::delete(File::glob($migrations.'/*_create_aircrafts_table.php'));
        File::delete(config_path('aircrafts.php'));

        $this->artisan('aircrafts:install')
            ->expectsConfirmation('Run the migration and seed the aircrafts table now?', 'no')
            ->assertSuccessful();

        $this->assertFileExists(config_path('aircrafts.php'));
        $this->assertCount(1, File::glob($migrations.'/*_create_aircrafts_table.php'));

        File::delete(File::glob($migrations.'/*_create_aircrafts_table.php'));
        File::delete(config_path('aircrafts.php'));
    }
}
