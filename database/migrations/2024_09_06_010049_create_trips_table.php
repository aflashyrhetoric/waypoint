<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->id();

            // departure_time and arrival_time are stored as timestamps
            $table->timestamp('departing_departure_time');
            $table->timestamp('departing_arrival_time')->nullable();
            $table->timestamp('returning_departure_time')->nullable();
            $table->timestamp('returning_arrival_time')->nullable();

            // boolean "had_accident" and "had_construction"
            $table->boolean('had_accident')->default(false);
            $table->boolean('had_construction')->default(false);

            $table->boolean('completed')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
