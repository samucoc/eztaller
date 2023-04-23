<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InformekardexController extends Controller
{
    public function index(){
		return view('adminlte::cobranza.informes.informe_kardex');
	}
}
