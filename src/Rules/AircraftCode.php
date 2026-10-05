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
        // JSON clients often send all-digit codes such as 738 as numbers; no code has a leading zero to lose.
        if (is_int($value)) {
            $value = (string) $value;
        }

        if (! is_string($value) || ! app(Aircrafts::class)->exists($value)) {
            $fail('The :attribute must be a valid IATA aircraft type code.');
        }
    }
}
