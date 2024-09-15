<div
    class="grid transition-all grid-cols-12 bg-white gap-4 p-4 rounded-xl {{ $trip->completed ? "opacity-50 hover:opacity-100": "opacity-100" }}">
    <div class="col-span-10 text-lg md:text-2xl font-bold">
        <livewire:time-format-string-long :date="$trip->departing_departure_time"/>
    </div>
    <i class="col-span-2 flex justify-end bi bi-trash text-red-600 cursor-pointer" wire:click="deleteTrip"></i>
    <div class="flex flex-col col-span-12 lg:col-span-6">
        <p class="mb-2 font-bold text-xl">
            Morning <i class="bi bi-brightness-high text-yellow-500"></i>
        </p>
        <div class="flex flex-col gap-y-3 justify-center">
            <div class="flex space-x-2">
                <div>
                        <button wire:click="toggleAccidentDeparting"
                                disabled="{{ $trip->completed }}"
                                class="border text-xs rounded-lg px-2 p-1 {{ $trip->accident_departing ? "border-blue-500": " hover:border-blue-500 border-gray-300" }} ">
                            @if($trip->accident_departing)
                                <i class="bi bi-dash"></i>
                            @else
                                <i class="bi bi-plus"></i>
                            @endif
                            {{ $trip->accident_departing ? "Accident": "Accident"}}
                        </button>
                </div>
                <div>
                        <button wire:click="toggleConstructionDeparting"
                                disabled="{{ $trip->completed }}"

                                class="border text-xs rounded-lg px-2 p-1 {{ $trip->construction_departing ? "border-blue-500": " hover:border-blue-500 border-gray-300" }} ">
                            @if($trip->construction_departing)
                                <i class="bi bi-dash"></i>
                            @else
                                <i class="bi bi-plus"></i>
                            @endif

                            {{ $trip->construction_departing ? "Construction" : "Construction" }}
                        </button>
                </div>
            </div>
            <div class="">
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
            <div class="">
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
    <div class="flex flex-col col-span-12 lg:col-span-6">
        <p class="mb-2 font-bold text-xl">
            Evening <i class="bi bi-moon text-indigo-700 ml-1"></i>
        </p>
        <div class="flex flex-col gap-y-3 justify-center">
            <div class="flex space-x-2">
                <div>
                    <button wire:click="toggleAccidentReturning"
                            disabled="{{ $trip->completed }}"
                            class="border text-xs rounded-lg px-2 p-1 {{ $trip->accident_returning ? "border-blue-500": " hover:border-blue-500 border-gray-300" }} ">
                        @if($trip->accident_returning)
                            <i class="bi bi-dash"></i>
                        @else
                            <i class="bi bi-plus"></i>
                        @endif

                        {{ $trip->accident_returning ? "Accident": "Accident"}}
                    </button>
                </div>
                <div>
                    <button wire:click="toggleConstructionReturning"
                            disabled="{{ $trip->completed }}"
                            class="border text-xs rounded-lg px-2 p-1 {{ $trip->construction_returning ? "border-blue-500": " hover:border-blue-500 border-gray-300" }} ">
                        @if($trip->construction_returning)
                            <i class="bi bi-dash"></i>
                        @else
                            <i class="bi bi-plus"></i>
                        @endif

                        {{ $trip->construction_returning ? "Construction": "Construction"}}
                    </button>
                </div>
            </div>
            <div class="">
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
            <div class="">
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
    <div class="col-span-6">
        <span class="font-bold">Duration:</span>
        @if ($this->departureDuration)
            <span>{{ $this->departureDuration }}</span>
        @else
            <span>N/A</span>
        @endif
    </div>
    <div class="col-span-6">
        <span class="font-bold">Duration:</span>
        @if ($this->returningDuration)
            <span>{{ $this->returningDuration }}</span>
        @else
            <span>N/A</span>
        @endif
    </div>

    <button wire:click="markComplete"
            class="col-span-12 border border-gray-700 p-3 rounded-lg hover:bg-gray-200 transition-colors">{{ $trip->completed ? "Undo" : "Mark Complete" }}</button>
</div>
