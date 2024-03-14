<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassengersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passengers = [
            [
                'booking_id' => 1,
                'first_name' => 'example_name',
                'last_name' => 'example_last_name',
                'birth_date' => '2004-04-04',
                'document_number' => '1111111111',
                'place_from' => '1c',
                'place_back' => '2d'
            ]
        ];

        DB::table('passengers')->insert($passengers);
    }
}
