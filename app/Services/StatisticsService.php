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
        $this->trips = Trip::all();
    }

    public function getStatistics(): StatisticsResults
    {
        $stats = new StatisticsResults();
        $stats->totalTrips = $this->trips->count();

        $stats = $this->calculateAverageDepartureTripDuration($stats);
        $stats = $this->calculateAverageReturningTripDuration($stats);

        $stats = $this->calculateAverageDelayWithAccidents($stats);
        $stats = $this->calculateAverageDelayFromConstruction($stats);

        $stats = $this->calculateAverageDepartingTripDurationPerDay($stats);
        $stats = $this->calculateAverageArrivingTripDurationPerDay($stats);
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
        if ($totalTrips === 0) {
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
        if ($totalTrips === 0) {
            return 0;
        }
        return $totalDuration / $totalTrips;
    }

    private function calculateAverageDelayWithAccidents(StatisticsResults $stats): StatisticsResults
    {
        /**
         * ACCIDENTS: DEPARTING
         */
        $departingTripsWithoutAccident = $this->trips->filter(function ($trip) {
            return !$trip->accident_departing;
        });
        $averageDepartingTripDurationNoAccidents = $this->getAverageDurationForDepartingTrips($departingTripsWithoutAccident);

        $returningTripsWithoutAccident = $this->trips->filter(function ($trip) {
            return !$trip->accident_returning;
        });
        $averageReturningTripDurationNoAccidents = $this->getAverageDurationForReturningTrips($returningTripsWithoutAccident);

        $departingTripsWithAccident = $this->trips->filter(function ($trip) {
            return $trip->accident_departing;
        });
        $averageDepartingTripDurationAccidents = $this->getAverageDurationForDepartingTrips($departingTripsWithAccident);
        $returningTripsWithAccident = $this->trips->filter(function ($trip) {
            return $trip->accident_returning;
        });
        $averageReturningTripDurationAccidents = $this->getAverageDurationForReturningTrips($returningTripsWithAccident);

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
        /**
         * CONSTRUCTION: DEPARTING
         */
        $departingTripsWithoutConstruction = $this->trips->filter(function ($trip) {
            return !$trip->construction_departing;
        });
        $averageDepartingTripDurationNoConstruction = $this->getAverageDurationForDepartingTrips($departingTripsWithoutConstruction);

        $returningTripsWithoutConstruction = $this->trips->filter(function ($trip) {
            return !$trip->construction_returning;
        });
        $averageReturningTripDurationNoConstruction = $this->getAverageDurationForReturningTrips($returningTripsWithoutConstruction);

        $departingTripsWithConstruction = $this->trips->filter(function ($trip) {
            return $trip->construction_departing;
        });
        $averageDepartingTripDurationConstruction = $this->getAverageDurationForDepartingTrips($departingTripsWithConstruction);
        $returningTripsWithConstruction = $this->trips->filter(function ($trip) {
            return $trip->construction_returning;
        });
        $averageReturningTripDurationConstruction = $this->getAverageDurationForReturningTrips($returningTripsWithConstruction);

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

    // Returns things as "05:22"
    private function convertDurationToString(int $duration): string
    {
        return Carbon::now()->startOfDay()->addMinutes($duration)->format('H:i');
    }

    private function calculateAverageDepartingTripDurationPerDay(StatisticsResults $stats): StatisticsResults
    {
        $totalTripsPerDay = [
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
        ];

        $totalDurationPerDay = [
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
        ];

        // Iterate through $this->trips, and add count and duration to corresponding variables
        foreach ($this->trips as $trip) {
            $day = Carbon::parse($trip->departing_departure_time)->dayName;
            $day = strtolower($day);

            // If it's saturday or sunday, skip
            if ($day === 'saturday' || $day === 'sunday') {
                continue;
            }

            $totalTripsPerDay[$day]++;
            $totalDurationPerDay[$day] += Carbon::parse($trip->departing_departure_time)->diffInMinutes(Carbon::parse($trip->departing_arrival_time));
        }

        $avgDurationPerDay = [];

        foreach ($totalDurationPerDay as $day => $totalDuration) {
            // If the $totalTripsPerDay[$day] is zero, set the average duration to zero
            if ($totalTripsPerDay[$day] === 0) {
                $avgDurationPerDay[$day] = 0;
                continue;
            }

            // Else Calculate the average duration
            $avgDuration = $totalDuration / $totalTripsPerDay[$day];

            // Cast $avgDurationPerDay[$day] to int
            $avgDurationPerDay[$day] = (int)$avgDuration;
        }

        $stats->averageDepartingTripDurationPerDay = $avgDurationPerDay;

        return $stats;
    }

    private function calculateAverageArrivingTripDurationPerDay(StatisticsResults $stats): StatisticsResults
    {
        $totalTripsPerDay = [
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
        ];

        $totalDurationPerDay = [
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 0,
            'thursday' => 0,
            'friday' => 0,
        ];

        // Iterate through $this->trips, and add count and duration to corresponding variables
        foreach ($this->trips as $trip) {
            $day = Carbon::parse($trip->returning_departure_time)->dayName;
            $day = strtolower($day);

            // If it's saturday or sunday, skip
            if ($day === 'saturday' || $day === 'sunday') {
                continue;
            }

            $totalTripsPerDay[$day]++;
            $totalDurationPerDay[$day] += Carbon::parse($trip->returning_departure_time)->diffInMinutes(Carbon::parse($trip->returning_arrival_time));
        }

        $avgDurationPerDay = [];

        foreach ($totalDurationPerDay as $day => $totalDuration) {
            // If the $totalTripsPerDay[$day] is zero, set the average duration to zero
            if ($totalTripsPerDay[$day] === 0) {
                $avgDurationPerDay[$day] = 0;
                continue;
            }

            // Else Calculate the average duration
            $avgDuration = $totalDuration / $totalTripsPerDay[$day];

            // Cast $avgDurationPerDay[$day] to int
            $avgDurationPerDay[$day] = (int)$avgDuration;
        }

        $stats->averageArrivingTripDurationPerDay = $avgDurationPerDay;

        return $stats;
    }
}
