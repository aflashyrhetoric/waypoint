<div class="col-span-12 xl:col-span-6 h-[95vh] overflow-y-scroll">
{{--    <h1 class="mb-4 text-lg">All Trips</h1>--}}
    {{--  A notice for when there's no trips  --}}
    @if($trips->isEmpty())
        <div class="h-48 text-blue-800">
            No trips found.
        </div>
    @endif

    <ul class="space-y-4 ">
        @foreach($trips as $trip)
            <livewire:trip-item :trip="$trip" :key="$trip->id"/>
        @endforeach
    </ul>
</div>
