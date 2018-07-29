<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IngresoValesController extends Controller
{
     public function index(){
		return view('adminlte::cobranza.ingreso_vales');
	}
}
