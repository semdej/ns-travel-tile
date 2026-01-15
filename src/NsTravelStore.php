<?php

namespace Spatie\NsTravelTile;

use Spatie\Dashboard\Models\Tile;

class NsTravelStore
{
    private const TILE_NAME = 'nsTravelTile';
    private const DATA_KEY = 'ns_travel_data';

    private Tile $tile;

    public static function make(): self
    {
        return new static();
    }

    public function __construct()
    {
        $this->tile = Tile::firstOrCreateForName(self::TILE_NAME);
    }

    public function setData(array $data): self
    {
        $this->tile->putData(self::DATA_KEY, $data);

        return $this;
    }

    public function getData(): array
    {
        return $this->tile->getData(self::DATA_KEY) ?? [];
    }
}
