<?php

namespace App\Models\Reservations;

use Illuminate\Database\Eloquent\Model;

class ReservationDetail extends Model
{
   protected  $fillable = [
   		'reservation_id',
   		'row',
   		'column'
   ];
}
