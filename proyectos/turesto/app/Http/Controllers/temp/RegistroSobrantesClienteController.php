<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistroSobrantesClienteController extends Controller
{
     public function index(){
		return view('adminlte::cobranza.registro_sobrantes_cliente');
	}
}
