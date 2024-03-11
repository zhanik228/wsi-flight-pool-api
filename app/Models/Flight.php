<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $appends = ['flight_id'];
    protected $hidden = ['id', 'from_id', 'to_id', 'updated_at', 'created_at'];

//    public function getFromAttribute() {
//        return $this->flightFrom->name;
//    }

    public function getFlightIdAttribute() {
        return $this->id;
    }
    public function getFlightFrommAttribute() {
        return $this->flightFrom;
    }

    public function getFlightTooAttribute() {
        return $this->flightTo;
    }

    public function flightFrom() {
        return $this->belongsTo(Airport::class, 'from_id');
    }

    public function flightTo() {
        return $this->belongsTo(Airport::class, 'to_id');
    }

//    public function getBookingAttribute() {
//        return Booking::where('flight_from', $this->id)->get();
//    }

    public function flightBooking() {
        return $this->hasOne(Booking::class,  'flight_from');
    }

    public function getFilteredFlights() {
        return [
            'flight_id' => $this->id,
            'flight_code' => $this->flight_code,
            'from' => $this->flightFrom,
            'to' => $this->flightTo,
            'cost' => $this->cost,
//            'availability' => 188 - intval($this->backBooking->bookingPassengers->count())
        ];
    }
}
