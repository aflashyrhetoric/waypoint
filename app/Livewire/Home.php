<?php

namespace App\Livewire;

use App\DTOs\StatisticsResults;
use App\Models\Trip;
use App\Services\StatisticsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    public $latest;

    public Collection $trips;


    public function mount(): void
    {
        $this->trips = Trip::all();
    }

    #[Computed]
    public function statisticsResults(): StatisticsResults
    {
        $statisticsService = new StatisticsService();
        return $statisticsService->getStatistics();
    }

    private function getRandomPastelColor(): string
    {
        // Ensure it's a bright pastel color
        return '#' . str_pad(dechex(mt_rand(0xaaaaaa, 0xeeeeee)), 6, '0', STR_PAD_LEFT);
    }

    #[Computed]
    public function columnChartModel(): ColumnChartModel
    {
        $columnChartModel =
            (new ColumnChartModel())
                ->setTitle('Avg Trip Duration (m)')
                ->setAnimated(true)
                ->withoutLegend();

        foreach ($this->statisticsResults->averageDurationPerDay as $day => $duration) {
            $columnChartModel->addColumn($day, $duration, $this->getRandomPastelColor());
        }


        return $columnChartModel;
    }

    #[Computed]
    public function inProgressTrips(): Collection
    {
        return $this->trips->where('completed', false);
    }

    #[Computed]
    public function completedTrips(): Collection
    {
        // Sorted by the 'departure_departing_time` with most recent first
        return $this->trips->where('completed', true)->sortByDesc('departing_departure_time');
    }

    #[On(['new-trip-added', 'trip-time-registered', 'deleted-trip', 'toggled-condition', 'toggled-completed'])]
    public function refreshTripList(): void
    {
        $this->trips = Trip::all();
    }

    #[Title('Waypoint')]
    public function render()
    {
        return view('livewire.home');
    }


}
