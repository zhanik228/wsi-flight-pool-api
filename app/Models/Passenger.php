<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $hidden = ['booking_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'place_from',
        'place_back'
    ];
}
