<?php

namespace App\Http\Controllers\booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBooking(Request $request, $code) {
        $booking = Booking::where('code', $code)->first();

        return [
            'data' => [
                'code' => $booking->code,
                'cost' => 0,
                'flights' => [
                    $booking->flight_fromm,
                    'to' => $booking->flight_too
                ],
                'passengers' => $booking->passengers
            ]
        ];
    }

    public function occupiedSeats($code) {
        $booking = Booking::where('code', $code)->first();

        return [
            'data' => [
                'occupied_from' => [
                    collect($booking->passengers)->map(function($passenger) {
                        return [
                            'passenger_id' => $passenger->id,
                            'place' => $passenger->place_from
                        ];
                    })
                ],
                'occupied_back' => [
                    collect($booking->passengers)->map(function($passenger) {
                        if ($passenger->place_back) {
                            return [
                                'passenger_id' => $passenger->id,
                                'place' => $passenger->place_back
                            ];
                        }
                        return [];
                    })
                ]
            ]
        ];
    }
}
