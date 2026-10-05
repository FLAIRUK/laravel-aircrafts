<?php

namespace FLAIRUK\Aircrafts\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Eloquent model for the optional aircrafts table (see `php artisan aircrafts:install`).
 *
 * @property int $id
 * @property string $code
 * @property string $name
 */
class Aircraft extends Model
{
    public $incrementing = false;

    public $timestamps = false;

    protected $guarded = [];

    public function getTable(): string
    {
        return config('aircrafts.table', 'aircrafts');
    }

    public function getConnectionName(): ?string
    {
        return $this->connection ?? config('aircrafts.connection');
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeCode(Builder $query, string $code): void
    {
        $query->where('code', strtoupper($code));
    }
}
