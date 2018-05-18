<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\Reservations\PremiereTime;
use App\Models\Reservations\Premiere;
use App\Models\Reservations\Chair;
use App\Models\Reservations\Reservation;
use App\Models\Reservations\ReservationDetail;

class PremiereController extends Controller
{
 		public function getTimeAll(Request $request)
 		{
 			if( $request->ajax() )
 			{
 				$pt = PremiereTime::where('date','>=', date('Y-m-d').' 00:00:00' )->get();
 				if( count($pt) && $pt !== null )
 				{
 					foreach($pt as $v)
 					{
 							$v->reservations=[];
 							$v->premiere = Premiere::where('id', $v->premiere_id)->first();
 							$reservations = Reservation::where('premiere_time_id', $v->id)->where('active', '1')->get();
 							if( count($reservations) && $reservations !== null )
 							{	
	 							foreach($reservations as $vr)
	 							{
	 								$vr->details =  ReservationDetail::where('reservation_id', $vr->id)->get();
	 							}
	 							$v->reservations = $reservations;
 							}
 							
 							$v->chair = Chair::where('id', $v->chair_id)->first();
 							$chairs = array();
 							for ( $r = 0; $r < $v->chair->rows; $r++) 
 							{
	 							for( $c = 0; $c <  $v->chair->columns; $c++) 
	 							{
	 								$chairs[$r][$c] = 0;
	 							}
 							}
 							$v->chairs = $chairs;
 							$v->chairVisible = false;
 					}
 					$return = ['submit'=> true, 'rows'=> $pt ];
 				}else{
 					$return = ['submit'=> false, 'msn'=> 'No hay eventos proximos para mostrar.'];
 				}
 				echo  json_encode($return);
 			}
 			else
 			{
 				echo "No se puede acceder";
 			}
 		}

 		public function availabilityChair($premiere_time_id,$row, $column)
 		{
				$r = DB::table('reservations')
               ->join('reservation_details',  'reservation_details.reservation_id', '=', 'reservations.id')
				       ->where('reservations.premiere_time_id', $premiere_time_id)
				       ->where('reservations.active', '1')
				       ->select('reservation_details.row','reservation_details.column')
				       ->get();
 			 	if( count($r) && $r !== null )
 			 	{
					foreach ($r as $v)
					{
						if( $v->row == $row && $v->column == $column)
						{
							return  false;
						}	
					}
	 			}
	 			return  true;
 		}

 		public function toAssing(Request $request)
 		{
 			if( $request->ajax() )
 			{
 					DB::beginTransaction();
 					$return=['submit'=> false, 'msn'=>  'No se realizo ninguna reserva.'];
 					$r = Reservation::create([
		 																"user_id"=> Auth::user()->id,
		 																"premiere_time_id"=> $request->premiere_time_id,
		 																"paid_price"=> 0,
		 																"number_people"=> 0
		 															]);
 					$number_people = 0; 
 					if($r !== null)
 					{
		 			 	foreach($request->chairs as $kr =>  $rows)
		 			 	{
		 					foreach ($rows as $kc => $column ) {
		 						 if( $column == 1 ){
		 						 		
		 						 		if( $this->availabilityChair($request->premiere_time_id,$kr, $kc) )
		 						 		{
			 						 		$rd = ReservationDetail::create([
						 						 																 "reservation_id"=>$r->id,
						 						 																 "row"=>$kr,
						 						 																 "column"=>$kc,
						 						 															]);
			 						 		if($rd !== null ){
			 						 			$number_people++;
			 						 		}else{
			 						 			$return = ['submit'=> false, 'msn'=> "Error  registrando un detalle de la reserva."];
			 						 			break;
			 						 		}
		 						 		}else{
			 						 			$return = ['submit'=> false, 'msn'=> "No puede realizar la reserva del butaco ".$kr."-".$kc." ya esta reservado."];
			 						 			break;
		 						 		}
		 						 }
		 					}
		 			 	}

		 			 	if($number_people){

		 			 		

		 			 		$return=['submit'=> true];
		 			 	}
 					}
 					else
 					{
 						$return = ['submit'=> false, 'msn'=> "Error  registrando el encabezado de la reserva."];
 					}

		 			if( $return['submit'] ) { DB::commit(); }
		 			else{ DB::rollBack();	}

		 			echo  json_encode($return);
 			}
 			else
 			{
 				echo "No se puede acceder";
 			}
 		}
}
