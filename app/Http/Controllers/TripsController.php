<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class TripsController extends Controller
{
    public function registerMe(Request $request)
    {
        // Get all trips that are incomplete
        $inProgressTrips = Trip::incomplete()->get();

        // Iterate over each trip - if it's from previous days, mark it complete
        $inProgressTrips->each(function ($trip) {
            $isFromBeforeToday = $trip->departing_departure_time->startOfDay()->isBefore(now()->startOfDay());
            if ($isFromBeforeToday) {
                $trip->update([
                    'completed' => true
                ]);
            }
        });

        // Get all trips that are incomplete
        $inProgressTrips = Trip::incomplete()->get();

        // If there are none, create one
        if ($inProgressTrips->isEmpty()) {
            Trip::create([
                'departing_departure_time' => now(),
            ]);
        }

        // If there is one, update it
        if ($inProgressTrips->count() === 1) {

            $orderOfFieldUpdates = [
                'departing_departure_time',
                'departing_arrival_time',
                'returning_departure_time',
                'returning_arrival_time',
            ];

            $fieldToUpdate = collect($orderOfFieldUpdates)->first(function ($field) use ($inProgressTrips) {
                return $inProgressTrips->first()->$field === null;
            });

            if ($fieldToUpdate === 'returning_arrival_time') {
                $inProgressTrips->first()->update([
                    $fieldToUpdate => now(),
                    'completed' => true
                ]);
            } else {
                $inProgressTrips->first()->update([
                    $fieldToUpdate => now()
                ]);
            }
        }
    }

    public function markAllAsCompleted()
    {
        $inProgressTrips = Trip::incomplete()->get();

        $inProgressTrips->each(function ($trip) {
            $trip->update([
                'completed' => true
            ]);
        });
    }
}
