<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   protected  $fillable = [
   		'user_id',
   		'premiere_time_id',
   		'paid_price',
   		'number_people'
   ];
}
