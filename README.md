<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="art/logo-dark.svg">
    <img src="art/logo-light.svg" alt="Laravel Aircrafts" width="420">
  </picture>
</p>

<h2 align="center">
  <a href="https://www.php.net/" target="_blank"><img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white" alt="PHP 8.2+"></a>&nbsp;
  <a href="https://laravel.com/docs/" target="_blank"><img src="https://img.shields.io/badge/Laravel-12%20%7C%2013-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel 12 or 13"></a>&nbsp;
  <a href="https://github.com/FLAIRUK/laravel-aircrafts/actions/workflows/tests.yml" target="_blank"><img src="https://img.shields.io/github/actions/workflow/status/FLAIRUK/laravel-aircrafts/tests.yml?branch=master&style=flat&logo=githubactions&logoColor=white&label=Tests" alt="Tests"></a>&nbsp;
  <a href="https://packagist.org/packages/ijeffro/laravel-aircrafts" target="_blank"><img src="https://img.shields.io/packagist/dt/ijeffro/laravel-aircrafts?style=flat&logo=packagist&logoColor=white&label=Downloads&color=F28D1A" alt="Downloads on Packagist"></a>&nbsp;
  <a href="https://github.com/FLAIRUK/laravel-aircrafts/blob/master/LICENSE" target="_blank"><img src="https://img.shields.io/github/license/FLAIRUK/laravel-aircrafts?style=flat&label=License&color=3DA639" alt="MIT licence"></a>&nbsp;
  <a href="https://www.iata.org/en/publications/directories/code-search/" target="_blank"><img src="https://img.shields.io/badge/Data-IATA-6D28D9?style=flat" alt="IATA"></a>&nbsp;
  <br>&nbsp;
</h2>

**Laravel Aircrafts** — IATA aircraft type designators (`320`, `738`, `388`, …) for Laravel 12 and 13.

- **No database required.** Look aircraft types up through a facade backed by an in-memory dataset.
- **Typed results.** Every lookup returns readonly `Aircraft` objects in Laravel collections keyed by code.
- **Validation rule.** `new AircraftCode` accepts known codes only.
- **Optional table.** Publish a migration and seed an `aircrafts` table.

<p align="center">
  📦&nbsp;<a href="#-installation">Installation</a> ·
  🚀&nbsp;<a href="#-usage">Usage</a> ·
  💾&nbsp;<a href="#-database-table-optional">Database table</a> ·
  🔄&nbsp;<a href="#-upgrading-from-dev-master">Upgrading</a>
</p>

<br><br>

## 📦 Installation

```bash
composer require ijeffro/laravel-aircrafts
```

Laravel discovers the service provider and the `Aircrafts` facade automatically.

<br><br>

## 🚀 Usage

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

<br><br>

## 💾 Database table (optional)

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

<br><br>

## 🔄 Upgrading from dev-master

Version 2 is a rewrite. Breaking changes:

| dev-master | 1.0 |
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

<br><br>

## 🧪 Testing

```bash
composer test
```

<br><br>

## 📄 License

MIT. See [LICENSE](LICENSE).
