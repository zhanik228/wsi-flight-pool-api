<?php

namespace App\Http\Controllers\booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBooking(Request $request, $code) {
        $booking = Booking::where('code', $code)->first();
        $totalCost = 0;

        $flights = [];

        $flights[] = $booking->getFlightDataWithoutKeys('flight_fromm');
        $flights[] = $booking->getFlightDataWithoutKeys('flight_too');

        collect($flights)->pluck('cost')->map(function($cost) use(&$totalCost) {
            $totalCost += $cost;
        });

        return [
            'data' => [
                'items' => $booking->bookingInfo()
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

    public function userBookings(Request $request) {
        $documentNumber = $request->user()->document_number;

        $bookings = Booking::whereHas('passenger', function ($query) use ($documentNumber) {
            $query->where('document_number', $documentNumber);
        })->get();

        $bookings = collect($bookings)->map(function($booking) {
            return $booking->bookingInfo();
        });

        return [
            'data' => [
                'items' => $bookings
            ]
        ];
    }
}
