<?php

namespace App\Http\Controllers\flights;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Booking;
use App\Models\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function search(Request $request) {
        $from = $request->from;
        $to = $request->to;
        $date1 = $request->date1;
        $date2 = $request->date2;

        $fromId = Airport::where('iata', $from)->first()->id;
        $toId = Airport::where('iata', $to)->first()->id;

//        Booking::where('flight_from', );

        $flightsTo = Flight::where('to_id', $toId)
            ->get()
            ->map(function($flight) {
                return $flight->getFilteredFlights();
            });

        $flightsFrom = Flight::where('from_id', $fromId)
            ->get()
            ->map(function($flight) {
                return $flight->getFilteredFlights();
            });

        return [
            'data' => [
                'flights_to' => $flightsTo,
                'flights_from' => $flightsFrom
            ]
        ];
    }
}
