<div class="">
    <div class="w-full p-4 bg-white rounded-lg tac">
        <h1 class="w-full font-medium mb-4 text-2xl"><i class="bi bi-bar-chart"></i> Trip Statistics</h1>
        <div class="grid-cols-12 grid gap-4">
            <div class="col-span-6">
                <p class="font-bold text-2xl mb-2">Departing</p>
                <div class="flex flex-col">
                    <p class="font-medium">Average:</p>
                    <p>{{ $statisticsResults->averageDepartureTripDurationString }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="font-medium">Average w/ Accident:</p>
                    <p>
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageDepartingDurationWithAccidentString }}</span>
                        <span
                            class="text-red-600">(+{{ $statisticsResults->averageDepartingDelayWithAccidentString }})</span>
                    </p>
                    <p class="font-medium">Average w/ Construction:</p>
                    <p>
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageDepartingDurationWithConstructionString }}</span>
                        <span
                            class="text-red-600">(+{{ $statisticsResults->averageDepartingDelayWithConstructionString }})</span>
                    </p>
                </div>
            </div>
            <div class="col-span-6">
                <p class="font-bold text-2xl mb-2">Returning</p>
                <div class="flex flex-col">
                    <p class="font-medium">Average:</p>
                    <p>{{ $statisticsResults->averageReturningTripDurationString }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="font-medium">Average w/ Accident:</p>
                    <p>
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageReturningDurationWithAccidentString }}</span>
                        <span class="text-red-600">
                            (+{{ $statisticsResults->averageReturningDelayWithAccidentString }})
                        </span>
                    </p>
                    <p class="font-medium">Average w/ Construction:</p>
                    <p>
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageReturningDurationWithConstructionString }}</span>
                        <span class="text-red-600">
                            (+{{ $statisticsResults->averageReturningDelayWithConstructionString }})
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
