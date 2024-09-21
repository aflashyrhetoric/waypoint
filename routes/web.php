<?php

use App\Http\Controllers\TripsController;
use App\Livewire\Home;
use App\Livewire\ShowTrips;
use App\Livewire\TripItem;
use Illuminate\Support\Facades\Route;

//Route::get('/', TripItem::class);
Route::get('/', Home::class);

Route::post('/trip/register/me', [TripsController::class, 'registerMe']);
