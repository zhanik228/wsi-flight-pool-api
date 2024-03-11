<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    use HasFactory;

    public function airportFlightsFrom() {
        return $this->belongsTo(Flight::class, 'from_id');
    }

    public function airportFlightsTo() {
        return $this->belongsTo(Flight::class, 'from_id');
    }

    public function airportBooking() {
        
    }
}
