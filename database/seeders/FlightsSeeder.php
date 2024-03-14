<?php

namespace Database\Seeders;

use App\Models\Airport;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FlightsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airportPeterburg = Airport::where('name', 'Air Peterburg')->firstOrFail();
        $airportMoscow = Airport::where('name', 'Air Moscow')->firstOrFail();
        $airportSheremyetovo = Airport::where('name', 'Sheremetyevo')->firstOrFail();

        $flights = [
            [
                'flight_code' => Str::random(5),
                'from_id' => $airportMoscow->id,
                'to_id' => $airportSheremyetovo->id,
                'time_from' => Carbon::now()->toTimeString(),
                'time_to' => Carbon::now()->addDay()->toTimeString(),
                'cost' => '9500',
                'created_at' => now(),
            ],
            [
                'flight_code' => Str::random(5),
                'from_id' => $airportSheremyetovo->id,
                'to_id' => $airportMoscow->id,
                'time_from' => Carbon::now()->toTimeString(),
                'time_to' => Carbon::now()->addDay()->toTimeString(),
                'cost' => '9500',
                'created_at' => now(),
            ],
            [
                'flight_code' => Str::random(5),
                'from_id' => $airportPeterburg->id,
                'to_id' => $airportSheremyetovo->id,
                'time_from' => Carbon::now()->toTimeString(),
                'time_to' => Carbon::now()->addDay()->toTimeString(),
                'cost' => '9200',
                'created_at' => now(),
            ],
        ];

        DB::table('flights')->insert($flights);
    }
}
