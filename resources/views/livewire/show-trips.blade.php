<div class="col-span-12 xl:col-span-6 overflow-y-scroll {{ $inProgress ? "" : "h-[95vh]" }} ">
{{--    <h1 class="mb-4 text-lg">All Trips</h1>--}}
    {{--  A notice for when there's no trips  --}}
    @if(count($trips) === 0)
        <div class="h-24 flex items-center justify-center text-xl text-blue-800">
            {{ $inProgress ? "Start a new journey by clicking above." : "No trips found"  }}
        </div>
    @endif

    <ul class="space-y-4 ">
        @foreach($trips as $trip)
            <livewire:trip-item :trip="$trip" :key="$trip->id"/>
        @endforeach
    </ul>
</div>
