<?php

namespace FLAIRUK\Aircrafts\Database;

use FLAIRUK\Aircrafts\Aircrafts;
use FLAIRUK\Aircrafts\Data\Aircraft as AircraftData;
use FLAIRUK\Aircrafts\Models\Aircraft;
use Illuminate\Database\Seeder;

/**
 * Upserts the aircraft dataset into the aircrafts table. Safe to run repeatedly.
 */
class AircraftsSeeder extends Seeder
{
    public function run(Aircrafts $aircrafts): void
    {
        $aircrafts->all()
            ->map(fn (AircraftData $aircraft) => $aircraft->toArray())
            ->chunk(500)
            ->each(fn ($chunk) => Aircraft::query()->upsert(
                $chunk->values()->all(),
                ['id'],
                ['code', 'name'],
            ));
    }
}
