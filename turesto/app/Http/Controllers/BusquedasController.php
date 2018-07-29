<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;
use App\Proveedores;
use DB;
use Response;

class BusquedasController extends Controller
{
	
    public function clientes(Request $request){
		$results = array();
		$queries = DB::table('clientes')
				->where('razon_social', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->cliente_ncorr, 'value' => $query->razon_social];
			}
		return Response::json($results);	
		}
	
	public function proveedores(Request $request){
		$results = array();
		$queries = DB::table('proveedores')
				->where('razon_social', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->nro_proveedor, 'value' => $query->razon_social];
			}
		return Response::json($results);	
	}

	public function Bancos(Request $request){
		$results = array();
		$queries = DB::table('bancos')
				->where('banco_descripcion', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->banco_id, 'value' => $query->banco_descripcion];
			}
		return Response::json($results);	
	}

	public function CuentasCorrientes(Request $request){
		$results = array();
		$queries = DB::table('cuentas_corrientes')
				->where('nro_cta_cte', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->cta_cte_ncorr, 'value' => $query->nro_cta_cte];
			}
		return Response::json($results);	
	}

	public function IngresoCompras(Request $request){
		$results = array();
		$queries = DB::table('ingreso_compras')
				->where('ic_ncorr', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->ic_ncorr, 'value' => $query->ic_ncorr];
			}
		return Response::json($results);	
	}

	public function Gastos(Request $request){
		$results = array();
		$queries = DB::table('gastos')
				->where('ic_ncorr', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->gast_ncorr, 'value' => $query->ic_ncorr];
			}
		return Response::json($results);	
	}

	public function TiposGastos(Request $request){
		$results = array();
		$queries = DB::table('tipos_gastos')
				->where('nombre', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->nro_gasto, 'value' => $query->nombre];
			}
		return Response::json($results);	
	}

	public function Afp(Request $request){
		$results = array();
		$queries = DB::table('afp')
				->where('nombre', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->afp_ncorr, 'value' => $query->nombre, 'porc_cot' => $query->porc_cot];
			}
		return Response::json($results);	
	}

	public function Ips(Request $request){
		$results = array();
		$queries = DB::table('ips')
				->where('nombre', 'LIKE', '%'.$request->term.'%')
				->take(5)->get();
		foreach ($queries as $query){
			    $results[] = [ 'id' => $query->ips_ncorr, 'value' => $query->nombre, 'porc_cot' => $query->porc_cot];
			}
		return Response::json($results);	
	}

}
