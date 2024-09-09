<div class="border rounded-lg text-white bg-indigo-900">
    <div class="relative h-[200px] xl:h-[25vh] flex items-center justify-center border border-gray-800 rounded-lg">
        <img
            class="absolute z-10 w-full h-full object-cover rounded-lg brightness-50 bg-top"
            src="{{asset('images/background.png')}}" alt="pleasant city illustration of people walking around"/>
        <h1 class="text-white text-xl xl:text-5xl font-extrabold z-20 flex items-center justify-center"><i class="bi bi-rocket text-7xl"></i>Waypoint</h1>
    </div>
    <div class="p-4">
        <h1 class="font-bold mb-4 text-lg xl:text-2xl">Create New Journey</h1>
        <button wire:click="addNew"
                class="border border-white p-3 rounded-lg fc hover:bg-gray-200 hover:text-gray-700 transition-colors"><i class="bi bi-plus-circle"></i> Log New Trip
        </button>
    </div>
</div>
