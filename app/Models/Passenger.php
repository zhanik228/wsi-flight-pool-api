<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;

    protected $hidden = ['booking_id', 'created_at', 'updated_at'];

    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'birth_date',
        'document_number',
        'place_from',
        'place_back'
    ];
}
