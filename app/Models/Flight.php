<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $appends = ['from'];

//    public function getFromAttribute() {
//        return $this->flightFrom->name;
//    }

    public function getFromAttribute() {
        return $this->flightFrom;
    }

    public function flightFrom() {
        return $this->belongsTo(Airport::class);
    }
}
