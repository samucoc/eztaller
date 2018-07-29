<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cumpleanos;
class CumpleanosController extends Controller
{
    public function getCumpleanos(){
    	$trabajadores = Cumpleanos::where('estado','=','1')->whereMonth('fecha_nac','=', date("m"))->orderby('fecha_nac','desc')->get();
    	return response()->json($trabajadores);
    }
}
