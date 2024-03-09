<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airports = [
            [
                'city' => 'Moscow',
                'name' => 'Air Moscow',
                'iata' => 'MSC'
            ],
            [
                'city' => 'Sankt Peterburg',
                'name' => 'Air Peterburg',
                'iata' => 'PTR'
            ],
            [
                'city' => 'Moscow',
                'name' => 'Sheremetyevo',
                'iata' => 'SVO'
            ]
        ];

        DB::table('airports')->insert($airports);
    }
}
