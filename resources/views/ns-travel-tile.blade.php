<x-dashboard-tile :position="$position">
    <div class="flex flex-col h-full">
        <div class="flex items-start justify-between gap-4">
            <div>
                <div class="text-lg font-semibold leading-tight">NS departures</div>
                <div class="text-xs uppercase tracking-wide opacity-70">Rotterdam area</div>
            </div>
            <div class="text-xs text-right opacity-70">
                <div class="font-semibold">{{ $stationName ?? 'Rotterdam Centraal' }}</div>
                @if($fetchedAt)
                    <div>Updated {{ \Illuminate\Support\Carbon::parse($fetchedAt)->format('H:i') }}</div>
                @endif
            </div>
        </div>

        <div wire:poll.{{ $refreshIntervalInSeconds }}s class="mt-3 divide-y divide-gray-200">
            @forelse($departures as $departure)
                @php
                    $plannedTime = data_get($departure, 'plannedDateTime');
                    $delayInSeconds = (int) data_get($departure, 'delayInSeconds', 0);
                    $delayMinutes = $delayInSeconds > 0 ? (int) ceil($delayInSeconds / 60) : 0;
                    $track = data_get($departure, 'plannedTrack');
                    $destination = data_get($departure, 'direction');
                    $category = data_get($departure, 'product.shortCategoryName', data_get($departure, 'trainCategory'));
                @endphp
                <div class="py-2 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-semibold truncate">{{ $destination ?? 'Unknown destination' }}</div>
                        <div class="text-xs opacity-70">
                            {{ $category ?? 'Train' }}
                            @if($track)
                                · Track {{ $track }}
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-mono">
                            {{ $plannedTime ? \Illuminate\Support\Carbon::parse($plannedTime)->format('H:i') : '--:--' }}
                        </div>
                        @if($delayMinutes > 0)
                            <div class="text-xs text-red-600">+{{ $delayMinutes }} min</div>
                        @else
                            <div class="text-xs opacity-60">On time</div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-sm opacity-70">No departures available.</div>
            @endforelse
        </div>
    </div>
</x-dashboard-tile>
