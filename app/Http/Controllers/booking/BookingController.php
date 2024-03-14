<?php

namespace App\Http\Controllers\booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function booking(Request $request) {
        $request->validate([
            'flight_from' => 'required',
            'flight_back' => 'required',
            'passengers' => 'required'
        ]);

        $flight_from = Flight::find($request->flight_from['id']);
        $flight_back = Flight::find($request->flight_back['id']);
        $passengers = $request->passengers;
        $arrPass = [];

        $createdBooking = Booking::create([
            'flight_from' => $flight_from->id,
            'flight_back' => $flight_back->id,
            'date_from' => $request->flight_from['date'],
            'date_back' => $request->flight_back['date'],
            'code' => Str::random(5)
        ]);

        foreach($passengers AS $passenger) {
            $arrPass[] = Passenger::create([
                'booking_id' => $createdBooking->id,
                'first_name' => $passenger['first_name'],
                'last_name' => $passenger['last_name'],
                'birth_date' => $passenger['birth_date'],
                'document_number' => $passenger['document_number'],
                'place_from' => strval(random_int(0, 12).Str::random(1)),
                'place_back' => strval(random_int(0, 12).Str::random(1))
            ]);
        }
        return response()->json([
            'data' => [
                'code' => $createdBooking->code
            ]
        ], 201);
    }

    public function selection(Request $request) {

        $request->validate([
            'passenger' => 'required',
            'seat' => 'required',
            'type' => 'required'
        ]);

        $passenger = Passenger::find($request->passenger);
        $seat = $request->seat;
        $type = $request->type;

        if (!$passenger) {
            return response()->json([
                'code' => 403,
                'message' => 'Passenger does not appply to booking'
            ], 403);
        }

//        проверить если место уже забронировано
        $seatIsOccupied = Passenger::where("place_$type", $seat)
                            ->where('id', '!=', $passenger->id)
                            ->exists();

        if ($seatIsOccupied) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Seat is occupied'
                ]
            ]);
        }

//        проверять и заменять места если места пустые
        switch ($type) {
            case 'from':
                    $passenger->update(['place_from' => $seat]);
                    return $passenger;
                    break;
            case 'back':
                    $passenger->update(['place_back' => $seat]);
                    break;
            default:
                    return 'no flight type selected';
        }
    }
}
