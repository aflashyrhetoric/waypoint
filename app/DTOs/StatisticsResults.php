<?php

namespace App\DTOs;

class StatisticsResults
{
    public int $totalTrips;
    public int $averageDepartureTripDuration; // minutes
    public string $averageDepartureTripDurationString; // HH:mm
    public int $averageReturningTripDuration; // minutes
    public string $averageReturningTripDurationString; // HH:mm

    public int $averageDepartingDurationWithAccident;
    public string $averageDepartingDurationWithAccidentString; // HH:mm
    public int $averageReturningDurationWithAccident;
    public string $averageReturningDurationWithAccidentString; // HH:mm
    public int $averageDepartingDelayWithAccident;
    public string $averageDepartingDelayWithAccidentString; // HH:mm
    public int $averageReturningDelayWithAccident;
    public string $averageReturningDelayWithAccidentString; // HH:mm


    public int $averageDepartingDurationWithConstruction;
    public string $averageDepartingDurationWithConstructionString; // HH:mm
    public int $averageReturningDurationWithConstruction;
    public string $averageReturningDurationWithConstructionString; // HH:mm
    public int $averageDepartingDelayWithConstruction;
    public string $averageDepartingDelayWithConstructionString; // HH:mm
    public int $averageReturningDelayWithConstruction;
    public string $averageReturningDelayWithConstructionString; // HH:mm

    public array $averageDepartingTripDurationPerDay;
    public array $averageArrivingTripDurationPerDay;

//    public int $averageDelayFromConstruction;
//    public int $averageDelayFromAll;
}
