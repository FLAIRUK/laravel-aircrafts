# Changelog

## 1.0.1 - 2026-10-05

- `codes()` returns every code as a string; all-digit ones such as `738` came back as integers.
- `AircraftCode` accepts an integer such as `738`, as JSON clients send it.
- README: requirements, `aircrafts:install --migrate` and the `sortBy` mapping.

## 1.0.0 - 2026-10-05

Complete rewrite for Laravel 12 and 13 (PHP 8.2+). See the upgrade guide in the README.

- In-memory lookup API (`find`, `findOrFail`, `exists`, `search`, `options`, …) returning readonly `Aircraft` objects.
- `AircraftCode` validation rule.
- Package auto-discovery; `FLAIRUK\Aircrafts` namespace.
- Optional publishable migration, Eloquent model, idempotent seeder, `aircrafts:install` and `aircrafts:seed` commands.
- Removed the meaningless `updated` field.
- Test suite and GitHub Actions CI.
