<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TripFactory extends Factory
{
    protected $model = Trip::class;

    public function definition(): array
    {
        // Generate random departure time
        $departingDepartureTime = Carbon::instance($this->faker->dateTimeBetween('-1 month', 'now'));

        // Generate varied arrival times, at least 45 minutes after departure
        $departingArrivalTime = (clone $departingDepartureTime)->addMinutes(rand(45, 180));

        $returningDepartureTime = (clone $departingArrivalTime)->addHours(8);
        $returningArrivalTime = (clone $returningDepartureTime)->addMinutes(rand(45, 180));

        $chanceOfAccident = $this->faker->boolean(20); // 20% chance of true

        // If true, add a few minutes to both arrival times
        if ($chanceOfAccident) {
            $departingArrivalTime->addMinutes(rand(5, 30));
            $returningArrivalTime->addMinutes(rand(5, 30));
        }

        $chanceOfConstruction = $this->faker->boolean(20); // 20% chance of true
        if($chanceOfConstruction) {
            $departingArrivalTime->addMinutes(rand(5, 30));
            $returningArrivalTime->addMinutes(rand(5, 30));
        }

        return [
            'departing_departure_time' => $departingDepartureTime,
            'departing_arrival_time' => $departingArrivalTime,
            'returning_departure_time' => $returningDepartureTime, // Nullable
            'returning_arrival_time' => $returningArrivalTime,    // Nullable
            'had_accident' => $chanceOfAccident, // 10% chance of true
            'had_construction' => $chanceOfConstruction, // 20% chance of true
            'completed' => true, // Assuming all trips are completed in this case
        ];
    }
}
