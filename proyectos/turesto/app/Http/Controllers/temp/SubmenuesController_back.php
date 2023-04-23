<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Submenu;

class SubmenuesController extends Controller
{
	//funcion para listar el submenu principal
    public function submenu(){
    	$submenues = Submenues::orderby('mhij_orden')->where('mhij_mostrar', '=', 'SI')->get();
    	return $submenues;
    }

    



}
