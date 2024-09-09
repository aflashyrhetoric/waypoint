<?php

namespace App\Livewire;

use App\Models\Trip;
use Illuminate\Support\Carbon;
use Livewire\Component;

class CreateTrip extends Component
{
    public function markAllIncompleteTripsComplete(): void
    {
        $unfinished = Trip::incomplete()->get();
        foreach ($unfinished as $trip) {
            $trip->update([
                'completed' => true,
            ]);
        }
    }
    public function addNew(): void
    {
        $this->markAllIncompleteTripsComplete();

        Trip::create([
            'departing_departure_time' => Carbon::now(),
        ]);

        $this->dispatch('new-trip-added');
    }

    public function render()
    {
        return view('livewire.create-trip');
    }
}
