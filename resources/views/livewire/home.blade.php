<div class="p-4 bg-gradient-to-br from-violet-300 to-indigo-300 grid grid-cols-12 gap-4" wire:trip-time-registered="$refresh">
    <div class="col-span-12 xl:col-span-6 space-y-4">
        <livewire:create-trip/>
        <livewire:show-trips :trips="$this->inProgressTrips" inProgress />
        <x-statistics-view :statisticsResults="$this->statisticsResults"/>
    </div>
    <livewire:show-trips :trips="$this->completedTrips" />
</div>
