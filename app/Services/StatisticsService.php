<?php

namespace App\Services;

use App\DTOs\StatisticsResults;
use App\Models\Trip;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StatisticsService
{

    public Collection $trips;

    public function __construct()
    {
        $this->trips = Trip::loadTrips();
    }

    public function getStatistics(): StatisticsResults
    {
        $stats = new StatisticsResults();
        $stats->totalTrips = $this->trips->count();

        $stats = $this->calculateAverageDepartureTripDuration($stats);
        $stats = $this->calculateAverageReturningTripDuration($stats);

        $stats = $this->calculateAverageDelayWithAccidents($stats);
        $stats = $this->calculateAverageDelayFromConstruction($stats);
        return $stats;
    }

    private function calculateAverageDepartureTripDuration(StatisticsResults $stats): StatisticsResults
    {
        $stats->averageDepartureTripDuration = $this->getAverageDurationForDepartingTrips($this->trips);
        $stats->averageDepartureTripDurationString = Carbon::now()->startOfDay()->addMinutes($stats->averageDepartureTripDuration)->format('H:i');

        return $stats;
    }

    private function calculateAverageReturningTripDuration(StatisticsResults $stats): StatisticsResults
    {
        $stats->averageReturningTripDuration = $this->getAverageDurationForReturningTrips($this->trips);;
        $stats->averageReturningTripDurationString = Carbon::now()->startOfDay()->addMinutes($stats->averageReturningTripDuration)->format('H:i');
        return $stats;
    }

    private function getAverageDurationForDepartingTrips(Collection $trips): int
    {
        $totalDuration = 0;
        $totalTrips = 0;
        foreach ($trips as $trip) {
            if ($trip->departing_departure_time !== null && $trip->departing_arrival_time !== null) {
                $departingDepartureTime = Carbon::parse($trip->departing_departure_time);
                $departingArrivalTime = Carbon::parse($trip->departing_arrival_time);
                $totalDuration += $departingDepartureTime->diffInMinutes($departingArrivalTime);
                $totalTrips++;
            }
        }
        if($totalTrips === 0){
            return 0;
        }
        return $totalDuration / $totalTrips;
    }

    private function getAverageDurationForReturningTrips(Collection $trips): int
    {
        $totalDuration = 0;
        $totalTrips = 0;
        foreach ($trips as $trip) {
            if ($trip->returning_departure_time !== null && $trip->returning_arrival_time !== null) {
                $returningDepartureTime = Carbon::parse($trip->returning_departure_time);
                $returningArrivalTime = Carbon::parse($trip->returning_arrival_time);
                $totalDuration += $returningDepartureTime->diffInMinutes($returningArrivalTime);
                $totalTrips++;
            }
        }
        if($totalTrips === 0){
            return 0;
        }
        return $totalDuration / $totalTrips;
    }

    private function calculateAverageDelayWithAccidents(StatisticsResults $stats): StatisticsResults
    {
        $tripsWithoutAccident = $this->trips->filter(function ($trip) {
            return !$trip->had_accident;
        });
        $averageDepartingTripDurationNoAccidents = $this->getAverageDurationForDepartingTrips($tripsWithoutAccident);
        $averageReturningTripDurationNoAccidents = $this->getAverageDurationForReturningTrips($tripsWithoutAccident);

        $tripsWithAccident = $this->trips->filter(function ($trip) {
            return $trip->had_accident;
        });
        $averageDepartingTripDurationAccidents = $this->getAverageDurationForDepartingTrips($tripsWithAccident);
        $averageReturningTripDurationAccidents = $this->getAverageDurationForReturningTrips($tripsWithAccident);

        // The durations themselves with accidents
        $stats->averageDepartingDurationWithAccident = $averageDepartingTripDurationAccidents;
        $stats->averageDepartingDurationWithAccidentString = $this->convertDurationToString($stats->averageDepartingDurationWithAccident);
        $stats->averageReturningDurationWithAccident = $averageReturningTripDurationAccidents;
        $stats->averageReturningDurationWithAccidentString = $this->convertDurationToString($stats->averageReturningDurationWithAccident);

        // The DELAYS incurred because of accidents
        $stats->averageDepartingDelayWithAccident = $averageDepartingTripDurationAccidents - $averageDepartingTripDurationNoAccidents;
        $stats->averageDepartingDelayWithAccidentString = $this->convertDurationToString($stats->averageDepartingDelayWithAccident);
        $stats->averageReturningDelayWithAccident = $averageReturningTripDurationAccidents - $averageReturningTripDurationNoAccidents;
        $stats->averageReturningDelayWithAccidentString = $this->convertDurationToString($stats->averageReturningDelayWithAccident);
        return $stats;
    }

    private function calculateAverageDelayFromConstruction(StatisticsResults $stats): StatisticsResults
    {
        $tripsWithoutConstruction = $this->trips->filter(function ($trip) {
            return !$trip->had_construction;
        });
        $averageDepartingTripDurationNoConstruction = $this->getAverageDurationForDepartingTrips($tripsWithoutConstruction);
        $averageReturningTripDurationNoConstruction = $this->getAverageDurationForReturningTrips($tripsWithoutConstruction);

        $tripsWithConstruction = $this->trips->filter(function ($trip) {
            return $trip->had_construction;
        });
        $averageDepartingTripDurationConstruction = $this->getAverageDurationForDepartingTrips($tripsWithConstruction);
        $averageReturningTripDurationConstruction = $this->getAverageDurationForReturningTrips($tripsWithConstruction);

        // The durations themselves with construction
        $stats->averageDepartingDurationWithConstruction = $averageDepartingTripDurationConstruction;
        $stats->averageDepartingDurationWithConstructionString = $this->convertDurationToString($stats->averageDepartingDurationWithConstruction);
        $stats->averageReturningDurationWithConstruction = $averageReturningTripDurationConstruction;
        $stats->averageReturningDurationWithConstructionString = $this->convertDurationToString($stats->averageReturningDurationWithConstruction);

        // The DELAYS incurred because of construction
        $stats->averageDepartingDelayWithConstruction = $averageDepartingTripDurationConstruction - $averageDepartingTripDurationNoConstruction;
        $stats->averageDepartingDelayWithConstructionString = $this->convertDurationToString($stats->averageDepartingDelayWithConstruction);
        $stats->averageReturningDelayWithConstruction = $averageReturningTripDurationConstruction - $averageReturningTripDurationNoConstruction;
        $stats->averageReturningDelayWithConstructionString = $this->convertDurationToString($stats->averageReturningDelayWithConstruction);
        return $stats;
    }

    private function convertDurationToString(int $duration): string
    {
        return Carbon::now()->startOfDay()->addMinutes($duration)->format('H:i');
    }
}
