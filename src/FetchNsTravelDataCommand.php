<?php

namespace Spatie\NsTravelTile;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNsTravelDataCommand extends Command
{
    protected $signature = 'dashboard:fetch-ns-travel-data';

    protected $description = 'Fetch NS travel departures for the dashboard tile';

    public function handle(): int
    {
        $apiKey = config('dashboard.tiles.ns_travel.api_key', env('NS_API_KEY'));
        $station = config('dashboard.tiles.ns_travel.station', 'Rotterdam Centraal');
        $maxJourneys = config('dashboard.tiles.ns_travel.max_journeys', 6);
        $endpoint = config(
            'dashboard.tiles.ns_travel.endpoint',
            'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures'
        );

        if (!$apiKey) {
            $this->error('Missing NS API key. Set dashboard.tiles.ns_travel.api_key or NS_API_KEY.');

            return Command::FAILURE;
        }

        $this->info("Fetching NS departures for {$station}...");

        $response = Http::withHeaders([
            'Ocp-Apim-Subscription-Key' => $apiKey,
        ])->get($endpoint, [
            'station' => $station,
            'maxJourneys' => $maxJourneys,
        ]);

        if (!$response->successful()) {
            $this->error('NS API request failed: ' . $response->status());

            return Command::FAILURE;
        }

        $payload = $response->json();
        $departures = data_get($payload, 'payload.departures', data_get($payload, 'departures', []));

        NsTravelStore::make()->setData([
            'station' => data_get($payload, 'payload.station', $station),
            'departures' => $departures,
            'fetched_at' => now()->toIso8601String(),
        ]);

        $this->info('All done!');

        return Command::SUCCESS;
    }
}
