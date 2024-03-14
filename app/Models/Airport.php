<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

//    protected $appends = ['airport'];
    protected $hidden = ['id', 'name', 'created_at', 'updated_at'];

    public function getFilteredAirports() {
        $timeFrom = $this->airportFlightsFrom()->first();
        $timeTo = $this->airportFlightsTo()->first();

        if ($timeFrom !== null) {
            $time = $timeFrom->time_from;
        } elseif ($timeTo !== null) {
            $time = $timeTo->time_from;
        } else {
            $time = null;
        }

        return [
            'city' => $this->city,
            'airport' => $this->name,
            'iata' => $this->iata,
            'time' => $this->airportFlightsTo,
        ];
    }

    public function airportFlightsFrom() {
        return $this->belongsTo(Flight::class, 'to_id');
    }

    public function airportFlightsTo() {
        return $this->belongsTo(Flight::class, 'from_id');
    }

    public function airportBooking() {

    }
}
