<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RevisionVentasController extends Controller
{
    public function index(){
    	return view('adminlte::cobranza.revision_ventas');
    }
}
