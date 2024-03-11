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

//        return $fromId.$toId;
        $flightsTo = Flight::where('from_id', $fromId)
            ->where('to_id', $toId)
            ->get()
            ->map(function($flight) {
                return $flight->getFilteredFlights();
            });

        return [
            'data' => [
                'flights_to' => $flightsTo
            ]
        ];
    }
}
