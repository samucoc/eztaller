<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsignacionSobrantesController extends Controller
{	
	//function que llama a la vista de asignacion de sobrantes a travez de la ruta en el archivo web.php
    public function index(){
		return view('adminlte::cobranza.asignacion_sobrantes');
	}
}
