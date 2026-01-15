<?php

namespace Spatie\NsTravelTile;

use Livewire\Component;

class NsTravelTileComponent extends Component
{
    public string $position;

    public function mount(string $position): void
    {
        $this->position = $position;
    }

    public function render()
    {
        $data = NsTravelStore::make()->getData();

        return view('dashboard-ns-travel-tile::ns-travel-tile', [
            'departures' => $data['departures'] ?? [],
            'stationName' => $data['station'] ?? config('dashboard.tiles.ns_travel.station', 'Rotterdam Centraal'),
            'fetchedAt' => $data['fetched_at'] ?? null,
            'refreshIntervalInSeconds' => config('dashboard.tiles.ns_travel.refresh_interval_in_seconds') ?? 60,
        ]);
    }
}
