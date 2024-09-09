<?php

use App\Livewire\Home;
use App\Livewire\ShowTrips;
use App\Livewire\TripItem;
use Illuminate\Support\Facades\Route;

//Route::get('/', TripItem::class);
Route::get('/', Home::class);
