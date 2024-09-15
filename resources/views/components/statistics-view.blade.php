<div class="">
    <div class="w-full p-4 bg-white rounded-lg tac">
        <h1 class="w-full font-medium mb-4 text-2xl"><i class="bi bi-bar-chart"></i> Trip Statistics</h1>
        <div class="grid-cols-12 grid gap-4">
            <div class="cs-6">
                <p class="font-bold font-figtree text-2xl mb-2">Departing</p>
                <div class="flex flex-col">
                    <p class="stat-label">Average:</p>
                    <p class="stat-p">{{ $statisticsResults->averageDepartureTripDurationString }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="stat-label">w/ Accident:</p>
                    <p class="stat-p">
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageDepartingDurationWithAccidentString }}</span>
                        <span
                            class="text-red-600">(+{{ $statisticsResults->averageDepartingDelayWithAccidentString }} delay)</span>
                    </p>
                    <p class="stat-label">w/ Construction:</p>
                    <p class="stat-p">
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageDepartingDurationWithConstructionString }}</span>
                        <span
                            class="text-red-600">(+{{ $statisticsResults->averageDepartingDelayWithConstructionString }} delay)</span>
                    </p>
                </div>
            </div>
            <div class="cs-6">
                <p class="font-figtree font-bold text-2xl mb-2">Returning</p>
                <div class="flex flex-col">
                    <p class="stat-label">Average:</p>
                    <p class="stat-p">{{ $statisticsResults->averageReturningTripDurationString }}</p>
                </div>
                <div class="flex flex-col">
                    <p class="stat-label">w/ Accident:</p>
                    <p class="stat-p">
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageReturningDurationWithAccidentString }}</span>
                        <span class="text-red-600">
                            (+{{ $statisticsResults->averageReturningDelayWithAccidentString }} delay)
                        </span>
                    </p>
                    <p class="stat-label">w/ Construction:</p>
                    <p class="stat-p">
                        <span
                            class="text-gray-800">{{ $statisticsResults->averageReturningDurationWithConstructionString }}</span>
                        <span class="text-red-600">
                            (+{{ $statisticsResults->averageReturningDelayWithConstructionString }} delay)
                        </span>
                    </p>
                </div>
            </div>
            <div class="cs-12 min-h-[300px] border">
                {{-- Iterate through $this->averageDurationPerDay --}}
                <livewire:livewire-column-chart
                    key="{{ $columnChartModel->reactiveKey() }}"
                    :column-chart-model="$columnChartModel" />
            </div>
        </div>
    </div>
</div>
