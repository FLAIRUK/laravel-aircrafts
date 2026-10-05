<?php

namespace FLAIRUK\Aircrafts;

use FLAIRUK\Aircrafts\Data\Aircraft;
use Illuminate\Support\Collection;
use Illuminate\Support\ItemNotFoundException;

/**
 * In-memory lookup of IATA aircraft type designators.
 *
 * The dataset is loaded lazily on first use and kept for the lifetime of the
 * instance (bound as a singleton), so lookups never touch the database.
 */
class Aircrafts
{
    /** @var Collection<string, Aircraft>|null */
    protected ?Collection $aircrafts = null;

    public function __construct(
        protected string $path = __DIR__.'/../data/aircrafts.php',
    ) {}

    /**
     * Every aircraft type, keyed by IATA code.
     *
     * @return Collection<string, Aircraft>
     */
    public function all(): Collection
    {
        return $this->aircrafts ??= collect(require $this->path)
            ->mapWithKeys(fn (array $row) => [$row['code'] => Aircraft::fromArray($row)]);
    }

    /**
     * Find an aircraft type by its three-character IATA code, e.g. "320" or "73H".
     */
    public function find(string $code): ?Aircraft
    {
        return $this->all()->get(strtoupper(trim($code)));
    }

    /**
     * @throws ItemNotFoundException
     */
    public function findOrFail(string $code): Aircraft
    {
        return $this->find($code) ?? throw new ItemNotFoundException("Unknown aircraft type code [{$code}].");
    }

    public function findById(int $id): ?Aircraft
    {
        return $this->all()->firstWhere('id', $id);
    }

    public function exists(string $code): bool
    {
        return $this->all()->has(strtoupper(trim($code)));
    }

    /**
     * Case-insensitive match against the code or name; an exact code match is ranked first.
     *
     * @return Collection<string, Aircraft>
     */
    public function search(string $term): Collection
    {
        $term = trim($term);

        if ($term === '') {
            return new Collection;
        }

        $exact = strtoupper($term);

        return $this->all()
            ->filter(fn (Aircraft $aircraft) => $aircraft->code === $exact || mb_stripos($aircraft->name, $term) !== false)
            ->sortBy(fn (Aircraft $aircraft) => $aircraft->code === $exact ? 0 : 1);
    }

    /**
     * Key/label pairs for a <select>, sorted by label.
     *
     * @return Collection<int|string, string>
     */
    public function options(string $key = 'code', string $label = 'name'): Collection
    {
        return $this->all()->sortBy($label, SORT_NATURAL | SORT_FLAG_CASE)->pluck($label, $key);
    }

    /**
     * @return list<string>
     */
    public function codes(): array
    {
        return $this->all()->keys()->all();
    }
}
