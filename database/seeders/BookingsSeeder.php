<?php

namespace Database\Seeders;

use App\Models\Airport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airportPeterburg = Airport::where('name', 'Air Peterburg')->firstOrFail();
        $airportMoscow = Airport::where('name', 'Air Moscow')->firstOrFail();
        $airportSheremyetovo = Airport::where('name', 'Sheremetyevo')->firstOrFail();

        $bookings = [
            [
                'flight_from' => 1,
                'flight_back' => 2,
                'date_from' => Carbon::now()->toDateTimeString(),
                'date_back' => Carbon::now()->subMonth()->toDateTimeString(),
                'code' => Str::random(5),
                'created_at' => now(),
            ],
            [
                'flight_from' => $airportSheremyetovo->id,
                'flight_back' => $airportMoscow->id,
                'date_from' => Carbon::now()->toDateTimeString(),
                'date_back' => Carbon::now()->subMonth()->toDateTimeString(),
                'code' => Str::random(5),
                'created_at' => now(),
            ]
        ];

        DB::table('bookings')->insert($bookings);
    }
}
