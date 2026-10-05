<?php

namespace FLAIRUK\Aircrafts\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\Collection<string, \FLAIRUK\Aircrafts\Data\Aircraft> all()
 * @method static \FLAIRUK\Aircrafts\Data\Aircraft|null find(string $code)
 * @method static \FLAIRUK\Aircrafts\Data\Aircraft findOrFail(string $code)
 * @method static \FLAIRUK\Aircrafts\Data\Aircraft|null findById(int $id)
 * @method static bool exists(string $code)
 * @method static \Illuminate\Support\Collection<string, \FLAIRUK\Aircrafts\Data\Aircraft> search(string $term)
 * @method static \Illuminate\Support\Collection<int|string, string> options(string $key = 'code', string $label = 'name')
 * @method static list<string> codes()
 *
 * @see \FLAIRUK\Aircrafts\Aircrafts
 */
class Aircrafts extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FLAIRUK\Aircrafts\Aircrafts::class;
    }
}
