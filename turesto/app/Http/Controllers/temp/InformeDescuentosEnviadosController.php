<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformeDescuentosEnviadosController extends Controller
{
    public function index(){
		return view('adminlte::cobranza.informes.informe_descuentos_enviados');
	}
}
