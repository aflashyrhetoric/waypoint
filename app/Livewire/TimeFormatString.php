<?php

namespace App\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class TimeFormatString extends Component
{
    public $date;

    public function mount($date): void
    {
        if ($date === null) {
            $this->date = null;
        } else {
            $this->date = Carbon::parse($date)->toIso8601String();
        }
    }

    public function render()
    {
        return view('livewire.time-format-string');
    }
}
