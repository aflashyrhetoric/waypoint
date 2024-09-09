<?php

namespace App\Livewire;

use App\Models\Trip;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class TripItem extends Component
{
    public $trip;
    public $date;

    public function mount($trip): void
    {
        $this->trip = $trip;
        if ($this->trip->returning_departure_time !== null && $this->trip->returning_arrival_time) {
            $this->returningDuration = Carbon::parse($this->trip->returning_departure_time)->diffForHumans(Carbon::parse($this->trip->returning_arrival_time), true);
        } else {
            $this->returningDuration = null;
        }
    }

    #[Computed]
    public function departureDuration()
    {
        if ($this->trip->departing_departure_time !== null && $this->trip->departing_arrival_time) {
            return Carbon::parse($this->trip->departing_departure_time)->diffForHumans(Carbon::parse($this->trip->departing_arrival_time), true);
        }
        return null;
    }

    #[Computed]
    public function returningDuration()
    {
        if ($this->trip->returning_departure_time !== null && $this->trip->returning_arrival_time) {
            return Carbon::parse($this->trip->returning_departure_time)->diffForHumans(Carbon::parse($this->trip->returning_arrival_time), true);
        }
        return null;
    }

    public function registerTimeFor($type): void
    {
        $updates = [];
        $updates[$type] = now();

        $this->trip->update($updates);

        $this->dispatch('trip-time-registered');
    }


    public function markComplete(): void
    {
        // Should toggle
        $this->trip->update([
            'completed' => !$this->trip->completed,
        ]);
    }

    public function deleteTrip(): void
    {
        $this->trip->delete();
        $this->dispatch('deleted-trip');
    }

    public function toggleAccidentDeparting(): void
    {
        $this->trip->update([
            'accident_departing' => !$this->trip->accident_departing,
        ]);
        $this->dispatch('toggled-condition');
    }

    public function toggleAccidentReturning(): void
    {
        $this->trip->update([
            'accident_returning' => !$this->trip->accident_returning,
        ]);
        $this->dispatch('toggled-condition');
    }

    public function toggleConstructionDeparting(): void
    {
        $this->trip->update([
            'construction_departing' => !$this->trip->construction_departing,
        ]);
        $this->dispatch('toggled-condition');
    }

    public function toggleConstructionReturning(): void
    {
        $this->trip->update([
            'construction_returning' => !$this->trip->construction_returning,
        ]);
        $this->dispatch('toggled-condition');
    }

    public function render()
    {
        return view('livewire.trip-item');
    }
}
