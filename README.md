# Laravel Aircrafts

[![Tests](https://github.com/FLAIRUK/laravel-aircrafts/actions/workflows/tests.yml/badge.svg)](https://github.com/FLAIRUK/laravel-aircrafts/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/ijeffro/laravel-aircrafts/v/stable)](https://packagist.org/packages/ijeffro/laravel-aircrafts)
[![License](https://poser.pugx.org/ijeffro/laravel-aircrafts/license)](https://packagist.org/packages/ijeffro/laravel-aircrafts)

IATA aircraft type designators (`320`, `738`, `388`, …) for Laravel 12 and 13.

- **No database required.** Look aircraft types up through a facade backed by an in-memory dataset.
- **Typed results.** Every lookup returns readonly `Aircraft` objects in Laravel collections keyed by code.
- **Validation rule.** `new AircraftCode` accepts known codes only.
- **Optional table.** Publish a migration and seed an `aircrafts` table.

## Installation

```bash
composer require ijeffro/laravel-aircrafts
```

Laravel discovers the service provider and the `Aircrafts` facade automatically.

## Usage

```php
use FLAIRUK\Aircrafts\Facades\Aircrafts;

Aircrafts::find('738');          // Aircraft { id: 55, code: "738", name: "Boeing 737-800" }
Aircrafts::findOrFail('388');    // throws ItemNotFoundException for unknown codes
Aircrafts::exists('73h');        // true (codes are case-insensitive)
Aircrafts::findById(55);

Aircrafts::all();                // Collection<string, Aircraft> keyed by code
Aircrafts::search('a380');       // matches on name or exact code
Aircrafts::codes();
```

### Select options

```php
Aircrafts::options();            // ['738' => 'Boeing 737-800', ...] sorted by name
```

### Validation

```php
use FLAIRUK\Aircrafts\Rules\AircraftCode;

$request->validate(['equipment' => ['required', new AircraftCode]]);
```

## Database table (optional)

```bash
php artisan aircrafts:install         # publish config + migration, then migrate and seed
php artisan aircrafts:seed            # insert / update (safe to re-run)
php artisan aircrafts:seed --prune    # also delete rows no longer in the dataset
```

You can also call the seeder from your own `DatabaseSeeder`:

```php
$this->call(\FLAIRUK\Aircrafts\Database\AircraftsSeeder::class);
```

The bundled `FLAIRUK\Aircrafts\Models\Aircraft` model gives you `Aircraft::code('738')->first()`. The table name and connection come from `AIRCRAFTS_TABLE` and `AIRCRAFTS_DB_CONNECTION`, or from the published config.

## Upgrading from 1.x / dev-master

Version 2 is a rewrite. Breaking changes:

| 1.x | 2.x |
| --- | --- |
| `ijeffro\Aircrafts\…` namespace | `FLAIRUK\Aircrafts\…` |
| Facade `ijeffro\Aircrafts\AircraftsFacade` | `FLAIRUK\Aircrafts\Facades\Aircrafts` (auto-discovered) |
| `Aircrafts::getList($sort)` (array) | `Aircrafts::all()->sortBy($sort)` (Collection of `Aircraft`) |
| `Aircrafts::getOne($id)` | `Aircrafts::findById($id)` or `Aircrafts::find($code)` |
| `Aircrafts::getListForSelect()` | `Aircrafts::options()` |
| `php artisan aircrafts:migration` | `php artisan aircrafts:install` / `aircrafts:seed` |
| Config key `aircrafts.table_name` | `aircrafts.table` |
| `updated` field (a 2015 import timestamp) | removed |

Row `id`s are unchanged.

## Testing

```bash
composer test
```

## License

MIT. See [LICENSE](LICENSE).
