<?php

namespace FLAIRUK\Aircrafts\Rules;

use Closure;
use FLAIRUK\Aircrafts\Aircrafts;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * Validates that the value is a known IATA aircraft designator.
 */
class AircraftCode implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! app(Aircrafts::class)->exists($value)) {
            $fail('The :attribute must be a valid IATA aircraft type code.');
        }
    }
}
