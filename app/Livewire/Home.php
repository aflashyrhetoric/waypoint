<?php

namespace App\Livewire;

use App\DTOs\StatisticsResults;
use App\Models\Trip;
use App\Services\StatisticsService;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class Home extends Component
{
    public $latest;

    public $trips;

    public function mount()
    {
        $this->trips = Trip::loadTrips();
    }

    #[Computed]
    public function statisticsResults(): StatisticsResults
    {
        $statisticsService = new StatisticsService();
        return $statisticsService->getStatistics();
    }

    #[On(['new-trip-added', 'trip-time-registered', 'deleted-trip', 'toggled-condition'])]
    public function refreshTripList(): void
    {
        $this->trips = Trip::loadTrips();
    }

    #[Title('Waypoint')]
    public function render()
    {
        return view('livewire.home');
    }


}
