<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class AirportsController extends Controller
{
    public function list(Request $request) {
        $query = $request->input('query');

        $airports = Airport::query()
            ->select('*')
            ->where(function (Builder $subQuery) use ($query) {
                $subQuery->where('city', 'like', '%'.$query.'%')
                ->orWhere('name', 'like', '%'.$query.'%')
                ->orWhere('iata', 'like', '%'.$query.'%');
            })
            ->get();

        return [
            'data' => [
                'items' => collect($airports)->map(function($airport) use ($airports) {
                    return [
                        'name' => $airport->name,
                        'iata' => $airport->iata,
                    ];
                })
            ]
        ];
    }
}
