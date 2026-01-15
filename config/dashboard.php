<?php

return [
    'tiles' => [
        'ns_travel' => [
            'api_key' => env('NS_API_KEY'),
            'station' => 'Rotterdam Centraal',
            'endpoint' => 'https://gateway.apiportal.ns.nl/reisinformatie-api/api/v2/departures',
            'max_journeys' => 6,
            'refresh_interval_in_seconds' => 60,
        ],
    ],
];
