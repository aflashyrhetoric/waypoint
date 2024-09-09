<?php

namespace App\Livewire;

use App\Models\Trip;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class ShowTrips extends Component
{
    #[Reactive]
    public $trips;

    public bool $inProgress;

    public function render()
    {
        // Pass the trips to the Livewire view
        return view('livewire.show-trips');
    }
}
