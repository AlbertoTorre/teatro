<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
      return view('reservations.show');
    }

    public function user(Request $request, $user_id=false)
    {
  		if( $request )
  		{	
  			
  		}
  		else
  		{
  			echo  "No es posible acceder.";
  		}
    }

}
