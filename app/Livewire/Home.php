<?php

namespace App\Livewire;

use App\DTOs\StatisticsResults;
use App\Models\Trip;
use App\Services\StatisticsService;
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
