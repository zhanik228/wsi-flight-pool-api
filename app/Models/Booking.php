<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $appends = ['flights', 'flight_fromm', 'flight_too', 'passengers'];

    public function getFlightsAttribute() {
        return $this->flightFrom;
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
}
