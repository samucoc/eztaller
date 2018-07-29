<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Migracionesyonley as M;
class MigracionesController extends Controller
{
    public function index(){
    	$clientes = M::where('sect_ncorr','=',1)->get();
    	dd($clientes);
    }
}
