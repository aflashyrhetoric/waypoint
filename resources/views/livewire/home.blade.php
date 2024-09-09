<div class="p-4 bg-indigo-50 grid grid-cols-12 gap-4" wire:trip-time-registered="$refresh">
    <div class="col-span-12 xl:col-span-6 space-y-4">
        <livewire:create-trip/>
        <div class="">
            <div class="w-full p-4 bg-white rounded-lg tac">
                <h1 class="w-full font-bold mb-4 text-2xl"><i class="bi bi-bar-chart"></i> Trip Statistics</h1>

                <div class="grid-cols-12 grid gap-4">
                    <div class="col-span-6">
                        Departing
                        <div class="flex flex-col">
                            <p class="font-bold">Average:</p>
                            <p>{{ $this->statisticsResults->averageDepartureTripDurationString }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-bold">Average w/ Accident:</p>
                            <p>
                                <span
                                    class="text-gray-800">{{ $this->statisticsResults->averageDepartingDurationWithAccidentString }}</span>
                                <span
                                    class="text-red-600">(+{{ $this->statisticsResults->averageDepartingDelayWithAccidentString }})</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-span-6">
                        Returning
                        <div class="flex flex-col">
                            <p class="font-bold">Average:</p>
                            <p>{{ $this->statisticsResults->averageReturningTripDurationString }}</p>
                        </div>
                        <div class="flex flex-col">
                            <p class="font-bold">Average w/ Accident:</p>
                            <p>
                                <span
                                    class="text-gray-800">{{ $this->statisticsResults->averageReturningDurationWithAccidentString }}</span>
                                <span class="text-red-600">
                                    (+{{ $this->statisticsResults->averageReturningDelayWithAccidentString }})
                                </span>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
    <livewire:show-trips :trips="$trips"/>
</div>
