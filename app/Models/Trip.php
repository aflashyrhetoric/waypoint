<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Trip extends Model
{
    use HasFactory;
    // guard the id
    protected $guarded = ['id'];

    public function dateString($date): string
    {
        if($date === null) {
            return '-';
        }
        // Return datetime as just "4:30 PM"
//        return Carbon::parse($date)->format('Y-m-d H:i:s');
        return Carbon::parse($date)->toIso8601String();
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    static public function loadTrips(): Collection
    {
        return Trip::all()->sortByDesc('created_at');
    }
}
