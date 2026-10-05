<?php

namespace FLAIRUK\Aircrafts\Data;

use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @implements Arrayable<string, int|string>
 */
final readonly class Aircraft implements Arrayable, JsonSerializable
{
    public function __construct(
        public int $id,
        public string $code,
        public string $name,
    ) {}

    /**
     * @param  array{id: int, code: string, name: string}  $row
     */
    public static function fromArray(array $row): self
    {
        return new self(
            id: $row['id'],
            code: $row['code'],
            name: $row['name'],
        );
    }

    /**
     * @return array{id: int, code: string, name: string}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
