<?php

namespace FLAIRUK\Aircrafts\Tests;

use FLAIRUK\Aircrafts\Aircrafts as AircraftsRepository;
use FLAIRUK\Aircrafts\Data\Aircraft;
use FLAIRUK\Aircrafts\Facades\Aircrafts;
use FLAIRUK\Aircrafts\Rules\AircraftCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ItemNotFoundException;
use PHPUnit\Framework\Attributes\Test;

class AircraftsTest extends TestCase
{
    #[Test]
    public function it_resolves_a_singleton_through_the_facade_and_alias(): void
    {
        $this->assertSame(app(AircraftsRepository::class), app('aircrafts'));
        $this->assertInstanceOf(AircraftsRepository::class, Aircrafts::getFacadeRoot());
    }

    #[Test]
    public function the_dataset_is_well_formed(): void
    {
        $aircrafts = Aircrafts::all();

        $this->assertGreaterThan(300, $aircrafts->count());
        $this->assertContainsOnlyInstancesOf(Aircraft::class, $aircrafts);
        $this->assertSame($aircrafts->count(), $aircrafts->pluck('id')->unique()->count(), 'ids must be unique');

        $aircrafts->each(function (Aircraft $aircraft, string $code) {
            $this->assertSame($code, $aircraft->code);
            $this->assertMatchesRegularExpression('/^[A-Z0-9]{3}$/', $aircraft->code);
            $this->assertNotSame('', $aircraft->name);
        });
    }

    #[Test]
    public function it_finds_aircraft_by_code_case_insensitively(): void
    {
        $this->assertSame('Airbus Industrie A380-800', Aircrafts::find(' 388 ')->name);
        $this->assertSame('73H', Aircrafts::find('73h')->code);
        $this->assertNull(Aircrafts::find('ZZZ'));
        $this->assertTrue(Aircrafts::exists('320'));
        $this->assertFalse(Aircrafts::exists('ZZZ'));
    }

    #[Test]
    public function find_or_fail_throws_for_unknown_codes(): void
    {
        $this->expectException(ItemNotFoundException::class);

        Aircrafts::findOrFail('ZZZ');
    }

    #[Test]
    public function it_finds_by_id(): void
    {
        $first = Aircrafts::all()->first();

        $this->assertSame($first, Aircrafts::findById($first->id));
        $this->assertNull(Aircrafts::findById(-1));
    }

    #[Test]
    public function it_searches_by_name_and_ranks_exact_code_matches_first(): void
    {
        $this->assertTrue(Aircrafts::search('a380')->has('388'));
        $this->assertSame('320', Aircrafts::search('320')->first()->code);
        $this->assertCount(0, Aircrafts::search(''));
    }

    #[Test]
    public function it_builds_select_options(): void
    {
        $options = Aircrafts::options();

        $this->assertSame(Aircrafts::all()->count(), $options->count());
        $this->assertSame('Boeing 737-800', $options['738']);
    }

    #[Test]
    public function data_objects_serialise_to_snake_case_arrays(): void
    {
        $this->assertSame(['id' => 55, 'code' => '738', 'name' => 'Boeing 737-800'], Aircrafts::find('738')->toArray());
        $this->assertJson(json_encode(Aircrafts::find('738')));
    }

    #[Test]
    public function the_validation_rule_accepts_known_codes_only(): void
    {
        $this->assertTrue(Validator::make(['type' => '738'], ['type' => new AircraftCode])->passes());
        $this->assertFalse(Validator::make(['type' => 'ZZZ'], ['type' => new AircraftCode])->passes());
        $this->assertFalse(Validator::make(['type' => 738], ['type' => new AircraftCode])->passes());
    }
}
