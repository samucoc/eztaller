<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformeSobrantesFaltantesController extends Controller
{
     public function index(){
		return view('adminlte::cobranza.informe_sobrantes_y_faltantes');
	}
}
