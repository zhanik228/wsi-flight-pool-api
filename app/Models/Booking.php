<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $appends = [
//        'flights',
        'flight_fromm',
        'flight_too',
        'passengers',
    ];
    protected $hidden = ['id'];

    public function getFlightsAttribute() {
        $flights = [];

//        $flights[] = $this->getFlightDataWithoutKeys('flight_fromm');
//        $flights[] = $this->getFlightDataWithoutKeys('flight_too');

        return $flights;
    }

    public function getFlightfrommAttribute() {
        return $this->flightFrom;
    }

    public function getFlighttooAttribute() {
        return $this->flightTo;
    }

    public function flightFrom() {
        return $this->belongsTo(Flight::class, 'flight_from');
    }

    public function flightTo() {
        return $this->belongsTo(Flight::class, 'flight_back');
    }

    public function getPassengersAttribute() {
        return $this->bookingPassengers;
    }
    public function bookingPassengers() {
        return $this->hasMany(Passenger::class);
    }

    public function getFlightDataWithoutKeys($flight_type) {
        return collect($this->$flight_type->getFilteredFlights());
    }

    public function passenger() {
        return $this->hasMany(Passenger::class);
    }

    public function bookingInfo() {
        $totalCost = 0;

        $flights = [];

        if ($this->flightFrom) {
            $flights[] = $this->getFlightDataWithoutKeys('flight_fromm');
        }
        if ($this->flightTo) {
            $flights[] = $this->getFlightDataWithoutKeys('flight_too');
        }
        collect($flights)->pluck('cost')->map(function($cost) use(&$totalCost) {
            $totalCost += $cost;
        });

        return [
            'code' => $this->code,
            'cost' => $totalCost,
            'flights' => $flights,
            'passengers' => $this->passengers
        ];
    }
}
