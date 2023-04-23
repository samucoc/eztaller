<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformeTraspasosController extends Controller
{
    public function index(){
		return view('adminlte::cobranza.informes.informe_traspasos');
	}
}
