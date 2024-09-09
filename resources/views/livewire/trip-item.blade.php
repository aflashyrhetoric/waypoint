<div
    class="grid transition-all grid-cols-12 bg-white gap-4 p-4 rounded-xl {{ $trip->completed ? "opacity-50 hover:opacity-100": "opacity-100" }}">
    <div class="col-span-12 grid grid-cols-12">
        <div class="col-span-1 h-8 w-8 rounded-lg bg-gray-800 text-white flex items-center justify-center mr-4">
            {{ $trip->id }}
        </div>

        <p class="col-span-5">
            <span class="font-bold">Departing trip:</span>
            @if ($this->departureDuration)
                <span>{{ $this->departureDuration }}</span>
            @else
                <span>N/A</span>
            @endif
        </p>
        <p class="col-span-5">
            <span class="font-bold">Returning trip:</span>
            @if ($this->returningDuration)
                <span>{{ $this->returningDuration }}</span>
            @else
                <span>N/A</span>
            @endif
        </p>
        <i class="col-span-1 bi bi-trash text-red-600 cursor-pointer" wire:click="deleteTrip"></i>
    </div>
    <div class="flex flex-col col-span-5">
        <p class="mb-2 font-bold text-2xl">
            Morning
        </p>
        <div class="flex flex-col gap-y-3 justify-center">
            <div class="flex justify-between">
                <div>
                    @if(!$trip->completed)
                        <button wire:click="toggleAccidentDeparting" class="underline">
                            {{ $trip->accident_departing ? "Undo Accident": "+ Accident"}}
                        </button>
                    @endif
                </div>
                <div>
                    @if(!$trip->completed)
                        <button wire:click="toggleConstructionDeparting" class="underline">
                            {{ $trip->construction_departing ? "Undo Construction" : "+ Construction" }}
                        </button>
                    @endif
                </div>
            </div>
            <div class="mr-2">
                @if($trip->departing_departure_time === null )
                    <button wire:click="registerTimeFor('departing_departure_time')"
                            class="border border-gray-700 p-1 rounded-lg fc hover:bg-gray-200 transition-colors">Set
                        Departure
                    </button>
                @else
                    Departed At:
                    <livewire:time-format-string :date="$trip->departing_departure_time"/>
                @endif
            </div>
            <div class="mr-2">
                @if($trip->departing_arrival_time === null )
                    <button wire:click="registerTimeFor('departing_arrival_time')"
                            class="border border-gray-700 p-1 rounded-lg fc hover:bg-gray-200 transition-colors">Set
                        Arrival
                    </button>
                @else
                    Arrived At:
                    <livewire:time-format-string :date="$trip->departing_arrival_time"/>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-col col-span-5">
        <p class="mb-2 font-bold text-2xl">
            Evening
        </p>
        <div class="flex flex-col gap-y-3 justify-center">
            <div class="flex justify-between">
                <div>
                    @if(!$trip->completed)
                        <button wire:click="toggleAccidentReturning" class="underline">
                            {{ $trip->accident_returning ? "Undo Accident": "+ Accident"}}
                        </button>
                    @endif
                </div>
                <div>
                    @if(!$trip->completed)
                        <button wire:click="toggleConstructionReturning" class="underline">
                            {{ $trip->construction_returning ? "Undo Construction": "+ Construction"}}
                        </button>
                    @endif
                </div>
            </div>
            <div class="mr-2">
                @if($trip->returning_departure_time === null )
                    <button wire:click="registerTimeFor('returning_departure_time')"
                            class="border border-gray-700 p-1 rounded-lg fc hover:bg-gray-200 transition-colors">Set
                        Departure
                    </button>
                @else
                    Departed At:
                    <livewire:time-format-string :date="$trip->returning_departure_time"/>
                @endif
            </div>
            <div class="mr-2">
                @if($trip->returning_arrival_time === null )
                    <button wire:click="registerTimeFor('returning_arrival_time')"
                            class="border border-gray-700 p-1 rounded-lg fc hover:bg-gray-200 transition-colors">Set
                        Arrival
                    </button>
                @else
                    Arrived At:
                    <livewire:time-format-string :date="$trip->returning_arrival_time"/>
                @endif
            </div>
        </div>
    </div>

    <button wire:click="markComplete"
            class="col-span-12 border border-gray-700 p-3 rounded-lg hover:bg-gray-200 transition-colors">{{ $trip->completed ? "Undo" : "Mark Complete" }}</button>
</div>
