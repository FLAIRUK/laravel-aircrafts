<?php

namespace FLAIRUK\Aircrafts\Console;

use FLAIRUK\Aircrafts\Aircrafts;
use FLAIRUK\Aircrafts\Database\AircraftsSeeder;
use FLAIRUK\Aircrafts\Models\Aircraft;
use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'aircrafts:seed')]
class SeedCommand extends Command
{
    protected $signature = 'aircrafts:seed
                            {--prune : Delete rows that are no longer in the dataset}';

    protected $description = 'Insert or update the aircrafts table from the bundled dataset';

    public function handle(Aircrafts $aircrafts): int
    {
        $this->laravel->call([$this->laravel->make(AircraftsSeeder::class), 'run']);

        if ($this->option('prune')) {
            $pruned = Aircraft::query()->whereNotIn('id', $aircrafts->all()->pluck('id'))->delete();
            $this->components->info("Pruned {$pruned} stale aircrafts.");
        }

        $this->components->info("Seeded {$aircrafts->all()->count()} aircrafts.");

        return self::SUCCESS;
    }
}
