<?php

namespace Spatie\NsTravelTile;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class NsTravelTileServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/dashboard.php', 'dashboard');

        if ($this->app->runningInConsole()) {
            $this->commands([
                FetchNsTravelDataCommand::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/dashboard-ns-travel-tile'),
        ], 'dashboard-ns-travel-tile-views');
        $this->publishes([
            __DIR__ . '/../config/dashboard.php' => config_path('dashboard.php'),
        ], 'dashboard-ns-travel-tile-config');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'dashboard-ns-travel-tile');

        Livewire::component('ns-travel-tile', NsTravelTileComponent::class);
    }
}
